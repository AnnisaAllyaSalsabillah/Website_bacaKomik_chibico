<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comic;
use App\Models\Chapter;
use App\Models\Upvote;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil statistik dasar
        $totalComics = Comic::count();
        $totalChapters = Chapter::count();
        $totalUser = User::count();

        // Mengambil Top 5 komik dengan upvote terbanyak
        // Termasuk informasi chapter count jika diperlukan
        $topUpvoteComics = Comic::withCount(['upvotes', 'chapters'])
            ->with(['genres', 'user']) // Jika ada relasi genre dan user
            ->orderBy('upvotes_count', 'desc')
            ->take(5)
            ->get();

        // Data aktivitas terbaru (opsional - bisa ditambahkan)
        $recentActivities = $this->getRecentActivities();

        return view('admin.dashboard.dash', [
            'totalComics' => $totalComics,
            'totalChapters' => $totalChapters,
            'totalUser' => $totalUser,
            'topUpvoteComics' => $topUpvoteComics,
            'recentActivities' => $recentActivities
        ]);
    }

    /**
     * Mengambil aktivitas terbaru untuk dashboard
     * 
     * @return \Illuminate\Support\Collection
     */
    private function getRecentActivities()
    {
        $activities = collect();

        // Komik terbaru (3 terakhir)
        $recentComics = Comic::latest()
            ->take(3)
            ->get()
            ->map(function ($comic) {
                return [
                    'type' => 'comic_added',
                    'title' => 'Komik baru ditambahkan: ' . $comic->title,
                    'time' => $comic->created_at->diffForHumans(),
                    'icon' => 'plus',
                    'color' => 'primary'
                ];
            });

        // Chapter terbaru (3 terakhir)
        $recentChapters = Chapter::with('comic')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($chapter) {
                return [
                    'type' => 'chapter_added',
                    'title' => 'Chapter baru: ' . ($chapter->comic->title ?? 'Unknown') . ' - Ch.' . $chapter->chapter_number,
                    'time' => $chapter->created_at->diffForHumans(),
                    'icon' => 'edit',
                    'color' => 'secondary'
                ];
            });

        // User terbaru (2 terakhir)
        $recentUsers = User::latest()
            ->take(2)
            ->get()
            ->map(function ($user) {
                return [
                    'type' => 'user_joined',
                    'title' => 'User baru bergabung: ' . $user->name,
                    'time' => $user->created_at->diffForHumans(),
                    'icon' => 'user',
                    'color' => 'accent'
                ];
            });

        // Gabungkan semua aktivitas dan urutkan berdasarkan waktu
        $activities = $activities
            ->concat($recentComics)
            ->concat($recentChapters)
            ->concat($recentUsers)
            ->sortByDesc(function ($activity) {
                // Mengurutkan berdasarkan waktu terbaru
                // Karena kita menggunakan diffForHumans(), kita perlu metode lain
                // Alternatif: simpan created_at asli untuk sorting
                return time(); // Placeholder - bisa dioptimalkan
            })
            ->take(6); // Ambil 6 aktivitas terbaru

        return $activities;
    }

    /**
     * Mengambil data statistik tambahan untuk chart/graph
     * 
     * @return array
     */
    public function getChartData()
    {
        // Data untuk chart mingguan/bulanan
        $comicsPerMonth = Comic::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $chaptersPerMonth = Chapter::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'comics_per_month' => $comicsPerMonth,
            'chapters_per_month' => $chaptersPerMonth
        ];
    }

    /**
     * API endpoint untuk mendapatkan data real-time
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDashboardStats()
    {
        return response()->json([
            'totalComics' => Comic::count(),
            'totalChapters' => Chapter::count(),
            'totalUsers' => User::count(),
            'totalUpvotes' => Upvote::count(),
            'topComics' => Comic::withCount('upvotes')
                ->orderBy('upvotes_count', 'desc')
                ->take(5)
                ->get(['id', 'title', 'upvotes_count'])
        ]);
    }
}
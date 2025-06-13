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
        $totalComics = Comic::count();
        $totalChapters = Chapter::count();
        $totalUser = User::count();
        $defaultComic = Comic::first();

        $topUpvoteComics = Comic::withCount(['upvotes', 'chapters'])
            ->with(['genres', 'user']) 
            ->orderBy('upvotes_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard.dash', [
            'totalComics' => $totalComics,
            'totalChapters' => $totalChapters,
            'totalUser' => $totalUser,
            'topUpvoteComics' => $topUpvoteComics,
            'defaultComic' => $defaultComic
        ]);
    }


    /**
     * 
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
     * 
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
<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Pengumuman;

class HomeController extends Controller
{
    public function index(Request $request)
{
    $type = $request->query('type', 'Manhwa');

    // Komik utama
    $comics = Comic::with('genres')
        ->where('type', $type)
        ->latest()
        ->take(12)
        ->get();

    // Komik rekomendasi
    $recommendedComics = Comic::withCount('upvotes')
        ->where('type', $type)
        ->orderByDesc('upvotes_count')
        ->take(9)
        ->get();

    // Komik update terbaru
    $latestUpdatedComics = Comic::with(['latestChapter'])
        ->where('type', $type)
        ->whereHas('chapters')
        ->withCount('upvotes')
        ->join('chapters', 'komiks.id', '=', 'chapters.komik_id')
        ->selectRaw('komiks.*, MAX(chapters.release_at) as latest_release')
        ->groupBy('komiks.id')
        ->orderByDesc('latest_release')
        ->take(9)
        ->get();


    // Komik populer berdasarkan upvotes
    $popularComics = Comic::withCount('upvotes')
        ->where('type', $type)
        ->orderByDesc('upvotes_count')
        ->take(9)
        ->get();

    $pengumuman = Pengumuman::latest()->get();

    return view('user.home.home', compact(
        'comics',
        'recommendedComics',
        'latestUpdatedComics',
        'popularComics',
        'type',
        'pengumuman'
    ));
}
}

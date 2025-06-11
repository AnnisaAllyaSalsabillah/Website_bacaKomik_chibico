<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comic;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    public function index()
    {
        // Ambil 4 komik terbaru untuk slider (misalnya yang ditandai sebagai "featured" di masa depan)
        $featuredComics = Comic::latest()->take(4)->get();

        // Ambil semua komik untuk ditampilkan di grid, sekaligus ambil genre-nya (eager loading)
        $comics = Comic::with('genres')->latest()->get();

        // Kirim ke view user.explore.index
        return view('user.explore.index', [
            'featuredComics' => $featuredComics,
            'comics' => $comics,
        ]);
    }
}

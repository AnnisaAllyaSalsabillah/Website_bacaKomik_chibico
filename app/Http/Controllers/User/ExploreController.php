<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comic;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    public function index()
    {
        // Ambil 4 komik terbaru untuk slider
        $featuredComics = Comic::latest()->take(4)->get();

        // Ambil semua komik untuk grid, lengkap dengan genre
        $comics = Comic::with('genres')->latest()->get();

        return view('user.explore.index', compact('featuredComics', 'comics'));
    }
}

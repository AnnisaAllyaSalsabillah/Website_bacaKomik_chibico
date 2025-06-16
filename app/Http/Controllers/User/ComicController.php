<?php

namespace App\Http\Controllers\User;

use App\Models\Comic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComicController extends Controller
{
    public function index(){
        $komiks = Comic::with('genres')->latest()->paginate(12);

        return view('user.komiks.index', compact('komiks'));
    }

    public function show($slug)
{
    $comic = Comic::with(['genres', 'chapters'])
                ->where('slug', $slug)
                ->firstOrFail();
        return view('user.komiks.show', compact('comic'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Comic;

class HomeController extends Controller
{
    public function index()
    {
        $comics = Comic::with('genres')->latest()->take(20)->get();
        
        return view('user.home.home', compact('comics'));
    }
}

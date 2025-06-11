<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Ambil jenis komik dari query parameter, default = 'Manhwa'
        $type = $request->query('type', 'Manhwa');

        // Ambil komik berdasarkan jenis yang dipilih
        $comics = Comic::with('genres')
            ->where('type', $type)
            ->latest()
            ->take(12) // Jumlah bisa disesuaikan
            ->get();

        return view('user.home.home', compact('comics', 'type'));
    }
}

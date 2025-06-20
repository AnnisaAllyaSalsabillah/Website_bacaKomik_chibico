<?php

namespace App\Http\Controllers\User;

use App\Models\Comic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    // Method untuk menampilkan halaman search
    public function show()
    {
        return view('user.search.result');
    }

    // Method untuk menangani pencarian
    public function index(Request $request)
    {
        // Jika tidak ada query, tampilkan halaman search
        if (!$request->has('query') || empty($request->query('query'))) {
            return view('user.search.result');
        }

        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        $query = $request->input('query');

        $result = Comic::where('title', 'like', '%' . $query . '%')
            ->orWhere('alternative', 'like', '%' . $query . '%')
            ->orWhere('author', 'like', '%' . $query . '%')
            ->orWhere('artist', 'like', '%' . $query . '%')
            ->get();

        return view('user.search.result', compact('result', 'query'));
    }
}
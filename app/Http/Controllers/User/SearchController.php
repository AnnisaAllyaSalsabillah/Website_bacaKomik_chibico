<?php

namespace App\Http\Controllers\User;

use App\Models\Comic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request){
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

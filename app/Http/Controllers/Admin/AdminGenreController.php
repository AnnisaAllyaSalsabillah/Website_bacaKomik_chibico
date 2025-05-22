<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;

class AdminGenreController extends Controller
{
    public function index()
    {
        $genres = Genre::all();
        return view('admin.genres.index', compact('genres'));
    }

    public function create()
    {
        return view('admin.genres.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255|unique:genres,name',
        ]);

        Genre::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.genres.index')->with('success', 'Yippy, Genre berhasil ditambahkan!');
    }

    public function edit($id){
        $genre = Genre::findOrFail($id);
        return view('admin.genres.edit', compact('genre'));
    }

    public function update(Request $request, $id){
        $genre = Genre::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . $genre->id,
        ]);

        $genre->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.genres.index')->with('success', 'Genre berhasil diupdate!');
    }

    public function destroy($id){
        $genre = Genre::findOrFail($id);
        $genre->delete();
        return redirect()->route('admin.genres.index')->with('success', 'Genre berhasil dihapus!');
    }
}

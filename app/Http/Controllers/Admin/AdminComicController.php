<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comic;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class AdminComicController extends Controller
{
    public function index() {
        $komiks = Comic::with('genres')->latest()->get();
        $genres = Genre::all();
        return view('admin.komiks.index', compact('komiks', 'genres'));
    }

    public function create() {
        $genres = Genre::all();
        return view('admin.komiks.create', compact('genres'));
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:komiks,slug',
            'sinopsis' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'alternative' => 'nullable|string',
            'author' => 'nullable|string',
            'artist' => 'nullable|string',
            'type' => 'required|in:manhwa,manhua,manga',
            'release_year' => 'nullable|string',
            'status' => 'required|in:ongoing,completed',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
        ]);

        $coverUrl = null;
        if($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imagePath = $image->getPathname();
            $imageName = $image->getClientOriginalName();

            $response = Http::withBasicAuth(env('IMAGEKIT_PRIVATE_KEY'), '')
                ->attach('file', fopen($imagePath, 'r'), $imageName)
                ->post('https://upload.imagekit.io/api/v1/files/upload', [
                    'fileName' => $imageName,
                    'folder' => '/chibico',
                ]);
            
            if($response->successful()) {
                $coverUrl = $response->json()['url'];
            }else {
                return back()->withErrors([
                    'cover_image' => 'Gagal mengunggah cover image'
                ]);
            }
            

        }

        $komik = Comic::create([
            'title' => $request->title,
            'slug' => $request->slug ?? Str::slug($request->title),
            'sinopsis' => $request->sinopsis,
            'cover_image' => $coverUrl,
            'rank' => 0,
            'alternative' => $request->alternative,
            'author' => $request->author,
            'artist' => $request->artist,
            'type' => $request->type,
            'release_year' => $request->release_year,
            'status' => $request->status,
        ]);

        if($request->genres) {
            $komik->genres()->attach($request->genres);
        }

        return redirect()->route('admin.komiks.index')->with(
            'success', 'Komik berhasil ditambahkan!'
        );
          
    }

    public function edit($id) {
        $komik = Comic::with('genres')->findOrFail($id);
        $genres = Genre::all();
        
        return response()->json([
            'komik' => $komik,
            'genres' => $genres,
        ]);
    }

    public function update(Request $request, $id) {
        $komik = Comic::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:komiks,slug,' . $komik->id,
            'sinopsis' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'rank' => 'nullable|string',
            'alternative' => 'nullable|string',
            'author' => 'nullable|string',
            'artist' => 'nullable|string',
            'type' => 'required|in:manhwa,manhua,manga',
            'release_year' => 'nullable|string',
            'status' => 'required|in:ongoing,completed',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
        ]);

        $coverUrl = $komik->cover_image;
        if($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imagePath = $image->getPathname();
            $imageName = $image->getClientOriginalName();

            $response = Http::withBasicAuth(env('IMAGEKIT_PRIVATE_KEY'), '')
                ->attach('file', fopen($imagePath, 'r'), $imageName)
                ->post('https://upload.imagekit.io/api/v1/files/upload', [
                    'fileName' => $imageName,
                    'folder' => '/chibico',
                ]);
            
            if($response->successful()) {
                $coverUrl = $response->json()['url'];
            }else {
                return back()->withErrors([
                    'cover_image' => 'Gagal mengunggah cover image'
                ]);
            }
        }

        $komik->update([
            'title' => $request->title,
            'slug' => $request->slug ?? Str::slug($request->title),
            'sinopsis' => $request->sinopsis,
            'cover_image' => $coverUrl,
            'rank' => $request->rank,
            'alternative' => $request->alternative,
            'author' => $request->author,
            'artist' => $request->artist,
            'type' => $request->type,
            'release_year' => $request->release_year,
            'status' => $request->status,
        ]);

        $komik->genres()->sync($request->genres);

        return redirect()->route('admin.komiks.index')->with(
            'success', 'Komik berhasil diperbarui!'
        );
    }

    public function show($id)
    {
        $komik = Comic::with('genres')->findOrFail($id);

        return response()->json([
            'komik' => $komik,
        ]);
    }



    public function destroy($id) {
        $komik = Comic::findOrFail($id);

        $komik->genres()->detach();
        $komik->delete();
        return redirect()->route('admin.komiks.index')->with(
            'success', 'Komik berhasil dihapus!'
        );
    }
}

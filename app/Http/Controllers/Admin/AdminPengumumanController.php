<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Http;

class AdminPengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::all();

        // Konversi data ke array sesuai format yang dibutuhkan JS
        $pengumumanData = $pengumuman->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'content' => $item->content,
                'thumbnail' => $item->thumbnail,
                'created_at' => $item->created_at ? $item->created_at->toIso8601String() : null,
                'formatted_date' => $item->created_at ? $item->created_at->format('d M Y') : null,
            ];
        })->toArray();

        // Kirim ke view
        return view('admin.pengumuman.index', compact('pengumuman', 'pengumumanData'));
    }

    public function create()
    {
        return view('admin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imageUrl = null;

        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $imagePath = $image->getPathname();
            $imageName = $image->getClientOriginalName();

            $response = Http::withBasicAuth(env('IMAGEKIT_PRIVATE_KEY'), '')
                ->attach('file', fopen($imagePath, 'r'), $imageName)
                ->post('https://upload.imagekit.io/api/v1/files/upload', [
                    'fileName' => $imageName,
                    'folder' => '/chibico/pengumuman',
                ]);

            \Log::info('Upload Response: ' . $response->body());

            if ($response->successful()) {
                $imageUrl = $response->json()['url'];
            } else {
                return back()->withErrors([
                    'thumbnail' => 'Gagal mengunggah thumbnail'
                ]);
            }
        }

        Pengumuman::create([
            'title' => $request->title,
            'content' => $request->content,
            'thumbnail' => $imageUrl,
            'date' => now(),
        ]);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Hoho, Pengumuman berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $thumbnailPath = $pengumuman->thumbnail;

        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $imagePath = $image->getPathname();
            $imageName = $image->getClientOriginalName();

            $response = Http::withBasicAuth(env('IMAGEKIT_PRIVATE_KEY'), '')
                ->attach('file', fopen($imagePath, 'r'), $imageName)
                ->post('https://upload.imagekit.io/api/v1/files/upload', [
                    'fileName' => $imageName,
                    'folder' => '/chibico/pengumuman',
                ]);

            \Log::info('Upload Response: ' . $response->body());

            if ($response->successful()) {
                $thumbnailPath = $response->json()['url'];
            } else {
                return back()->withErrors([
                    'thumbnail' => 'Gagal mengunggah thumbnail'
                ]);
            }
        }

        $pengumuman->update([
            'title' => $request->title,
            'content' => $request->content,
            'thumbnail' => $thumbnailPath,
            'date' => now(),
        ]);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Hoho, Pengumuman berhasil diupdate!');
    }



    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();
        return redirect()->route('admin.pengumuman.index')->with('success', 'Hoho, Pengumuman berhasil dihapus!');
    }
}

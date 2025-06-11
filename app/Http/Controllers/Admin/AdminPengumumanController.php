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
        $pengumuman = Pengumuman::orderBy('created_at', 'desc')->get();
        return view('admin.pengumuman.index', compact('pengumuman'));
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
            $imageData = base64_encode(file_get_contents($image));

            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Basic ' . base64_encode(env('IMAGEKIT_PRIVATE_KEY') . ':'),
                ])->post('https://upload.imagekit.io/api/v1/files/upload', [
                    'file' => 'data:' . $image->getMimeType() . ';base64,' . $imageData,
                    'fileName' => $image->getClientOriginalName(),
                    'folder' => '/chibico/pengumuman',
                ]);

                if ($response->successful()) {
                    $imageUrl = $response->json()['url'];
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengupload gambar: ' . $e->getMessage());
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

        $imageUrl = $pengumuman->thumbnail; // Keep existing thumbnail by default

        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageData = base64_encode(file_get_contents($image));

            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Basic ' . base64_encode(env('IMAGEKIT_PRIVATE_KEY') . ':'),
                ])->post('https://upload.imagekit.io/api/v1/files/upload', [
                    'file' => 'data:' . $image->getMimeType() . ';base64,' . $imageData,
                    'fileName' => $image->getClientOriginalName(),
                    'folder' => '/chibico/pengumuman',
                ]);

                if ($response->successful()) {
                    $imageUrl = $response->json()['url'];
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengupload gambar: ' . $e->getMessage());
            }
        }

        $pengumuman->update([
            'title' => $request->title,
            'content' => $request->content,
            'thumbnail' => $imageUrl,
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
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\ChapterImage;
use App\Models\Comic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class AdminChapterController extends Controller
{
    // TAMPILKAN LIST CHAPTER PER KOMIK
    public function index($id) {
        $komik = Comic::with('chapters')->findOrFail($id);
        $chapters = $komik->chapters()->latest()->get();
        return view('admin.chapters.index', compact('komik', 'chapters'));
    }

    // HALAMAN CREATE CHAPTER
    public function create($id) {
        $komik = Comic::findOrFail($id);
        return view('admin.chapters.create', compact('komik'));
    }

    // SIMPAN DATA CHAPTER
    public function store(Request $request, $id) {
        $request->validate([
            'chapter' => 'required|numeric',
            'title' => 'required|string|max:255',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $chapter = Chapter::create([
            'komik_id' => $id,
            'chapter' => $request->chapter,
            'title' => $request->title,
            'slug' => Str::slug('ch-'.$request->chapter.'-'.$request->title.'-'.Str::random(3)),
            'release_at' => now(),
        ]);

        if($request->hasFile('images')){
            foreach($request->file('images') as $index => $image){
                $imagePath = $image->getPathname();
                $imageName = $image->getClientOriginalName();

                $response = Http::withBasicAuth(env('IMAGEKIT_PRIVATE_KEY'), '')
                    ->attach('file', fopen($imagePath, 'r'), $imageName)
                    ->post('https://upload.imagekit.io/api/v1/files/upload', [
                        'fileName' => $imageName,
                        'folder' => '/chibico/chapters',
                    ]);

                if($response->successful()){
                    $imageUrl = $response->json()['url'];
                    $fileId = $response->json()['fileId'];

                    ChapterImage::create([
                        'chapter_id' => $chapter->id,
                        'image_path' => $imageUrl,
                        'file_id' => $fileId,
                        'page_number' => $index + 1,
                    ]);
                } else {
                    return back()->withErrors(['images' => 'Gagal mengunggah salah satu image']);
                }
            }
        }

        return redirect()->route('admin.chapters.index', $id)->with('success', 'Yippy, Chapter berhasil ditambahkan!');
    }

    public function show($komikId, $chapterId) {
        $chapter = Chapter::with(['images' => function($query) {
            $query->orderBy('page_number', 'asc');
        }])->where('komik_id', $komikId)->findOrFail($chapterId);
        
        return response()->json(['chapter' => $chapter]);
    }

    // HALAMAN EDIT CHAPTER
    public function edit($id, $chapterId) {
        $komik = Comic::findOrFail($id);
        $chapter = $komik->chapters()->with('images')->findOrFail($chapterId);
        return view('admin.chapters.edit', compact('komik', 'chapter'));
    }

    // UPDATE CHAPTER
    public function update(Request $request, $id, $chapterId) {
        $request->validate([
            'chapter' => 'required|numeric',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:chapters,slug,' . $chapterId,
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $komik = Comic::findOrFail($id);
        $chapter = $komik->chapters()->findOrFail($chapterId);

        $chapter->update([
            'chapter' => $request->chapter,
            'title' => $request->title,
            'slug' => $request->slug ?? Str::slug('ch-'.$request->chapter.'-'.$request->title.'-'.Str::random(3)),
            'release_at' => $request->release_at ?? $chapter->release_at,
        ]);

        if($request->hasFile('images')){
            // Hapus image lama di ImageKit
            foreach($chapter->images as $image){
                if($image->file_id){
                    Http::withBasicAuth(env('IMAGEKIT_PRIVATE_KEY'), '')
                        ->delete("https://api.imagekit.io/v1/files/{$image->file_id}");
                }
            }
            $chapter->images()->delete();

            // Upload ulang images baru dengan folder yang konsisten
            foreach($request->file('images') as $index => $image){
                $imagePath = $image->getPathname();
                $imageName = $image->getClientOriginalName();

                $response = Http::withBasicAuth(env('IMAGEKIT_PRIVATE_KEY'), '')
                    ->attach('file', fopen($imagePath, 'r'), $imageName)
                    ->post('https://upload.imagekit.io/api/v1/files/upload', [
                        'fileName' => $imageName,
                        'folder' => '/chibico/chapters', // Konsisten dengan method store
                    ]);

                if($response->successful()){
                    $imageUrl = $response->json()['url'];
                    $fileId = $response->json()['fileId'];

                    $chapter->images()->create([
                        'image_path' => $imageUrl,
                        'file_id' => $fileId,
                        'page_number' => $index + 1,
                    ]);
                } else {
                    return back()->withErrors(['images' => 'Gagal mengunggah salah satu image saat update']);
                }
            }
        }

        return redirect()->route('admin.chapters.index', $id)->with('success', 'Yippy, Chapter berhasil diupdate!');
    }

    public function getImages($id, $chapterId) {
        $chapter = Chapter::with('images')->findOrFail($chapterId);
        return response()->json([
            'images' => $chapter->images->sortBy('page_number')->values()
        ]);
    }

    public function viewChapter($id, $chapterId) {
        $komik = Comic::findOrFail($id);
        $chapter = Chapter::with(['images' => function($query) {
            $query->orderBy('page_number', 'asc');
        }])->where('komik_id', $id)->findOrFail($chapterId);
        
        return view('admin.chapters.view', compact('komik', 'chapter'));
    }

    // HAPUS CHAPTER
    public function destroy($komikId, $chapterId){
        $chapter = Chapter::with('images')->findOrFail($chapterId);

        // Hapus semua images dari ImageKit
        foreach($chapter->images as $image){
            if($image->file_id){
                Http::withBasicAuth(env('IMAGEKIT_PRIVATE_KEY'), '')
                    ->delete("https://api.imagekit.io/v1/files/{$image->file_id}");
            }
        }

        $chapter->delete();

        return redirect()->route('admin.chapters.index', $komikId)->with('success', 'Chapter berhasil dihapus!');
    }
}

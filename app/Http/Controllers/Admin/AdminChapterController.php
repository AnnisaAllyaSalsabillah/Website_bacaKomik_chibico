<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\ChapterImage;
use App\Models\Comic;
use Illuminate\Http\Request;
use Illuminate\Http\Requests;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;    

class AdminChapterController extends Controller
{
    public function index($id) {
        $komik = Comic::with('chapters')->findOrFail($id);
        $chapters = $komik->chapters()->latest()->get();

        return view('admin.chapters.index', compact('komik', 'chapters'));
    }

    public function create($id) {
        $komik = Comic::findOrFail($id);
        return view('admin.chapters.create', compact('komik'));
    }

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

                $response = Http::withBasicAuth(env('IMAGEKIT_PUBLIC_KEY'), env('IMAGEKIT_PRIVATE_KEY'))
                    ->attach('file', file_get_contents($imagePath), $imageName)
                    ->post('https://upload.imagekit.io/api/v1/files/upload', [
                        'fileName' => $imageName,
                        'folder' => '/chibico/chapters',
                    ]);

                if($response->successful()){
                    $imageUrl = $response->json()['url'];

                    ChapterImage::create([
                        'chapter_id' => $chapter->id,
                        'image_path' => $imageUrl,
                        'file_id' => $response->json()['fileId'],
                        'page_number' => $index + 1,
                    ]);
                }
            }
        }

        return redirect()->route('admin.chapters.index', $id)->with('success', 'Yippy, Chapter berhasil ditambahkan!');
    }

    public function edit($id, $chapterId) {
        $komik = Comic::findOrFail($id);
        $chapter = $komik->chapters()->with('images')->findOrFail($chapterId);
        return view('admin.chapters.edit', compact('komik', 'chapter'));
    }

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
            'slug' => $request->slug ?? Str::slug('chapter-'.$request->chapter),
            'release_at' => $request->release_at ?? now(),
        ]);

        if($request->hasFile('images')){
            foreach($chapter->images as $image){
                if($image->file_id){
                    Http::withBasicAuth(env('IMAGEKIT_PUBLIC_KEY'), env('IMAGEKIT_PRIVATE_KEY'))
                        ->delete("https://api.imagekit.io/v1/files/{$image->file_id}");
                }
            }
            $chapter->images()->delete();

            foreach($request->file('images') as $index => $image){
                $imagePath = $image->getPathname();
                $imageName = $image->getClientOriginalName();

                $response = Http::withBasicAuth(env('IMAGEKIT_PUBLIC_KEY'), env('IMAGEKIT_PRIVATE_KEY'))
                    ->attach('file', file_get_contents($imagePath), $imageName)
                    ->post('https://upload.imagekit.io/api/v1/files/upload', [
                        'fileName' => $imageName,
                        'folder' => "/chibico/chapters/{$chapter->slug}",
                    ]);

                if($response->successful()){
                    $imageUrl = $response->json()['url'];

                    $chapter->images()->create([
                        'image_path' => $imageUrl,
                        'file_id' => $response->json()['fileId'],
                        'page_number' => $index + 1,
                    ]);
                }
            }
        }

        return redirect()->route('admin.chapters.index', $id)->with('success', 'Yippy, Chapter berhasil diupdate!');
    }

    public function destroy($id){
        $chapter = Chapter::with('images')->findOrFail($id);

        foreach($chapter->images as $image){
            if($image->file_id){
                Http::withBasicAuth(env('IMAGEKIT_PUBLIC_KEY'), env('IMAGEKIT_PRIVATE_KEY'))
                    ->delete("https://api.imagekit.io/v1/files/{$image->file_id}");
            }
        }

        $chapter->delete();

        return redirect()->back()->with('success', 'Chapter berhasil dihapus!');
        
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Models\Comic;
use App\Models\Chapter;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function show($comicSlug, $chapterNumber){
        $komik = Comic::where('slug', $comicSlug)->firstOrFail();
        $chapter = Chapter::where('komik_id', $komik->id)->where('number', $chapterNumber)->firstOrFail();

        $prevChapter = Chapter::where('komik_id', $chapter->komik_id)->where('number', '<', $chapter->number)->orderBy('number')->first();
        $nextChapter = Chapter::where('komik_id', $chapter->komik_id)->where('number', '>', $chapter->number)->orderBy('number')->first();  

        if(Auth::check()) {
            History::updateOrCreate([
                'user_id' => Auth::user()->id,
                'komik_id' => $chapter->komik_id,
            ],
            [
                'chapter_id' => $chapter->id,
                'last_read' => now(),
            ]
            );
        }
        return view('chapter.show', [
            'komik' => $komik,
            'chapter' => $chapter,
            'prevChapter' => $prevChapter,
            'nextChapter' => $nextChapter,
        ]);
    }
}

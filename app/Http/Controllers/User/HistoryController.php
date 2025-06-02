<?php

namespace App\Http\Controllers\User;

use App\Models\History;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(){
        $histories = History::where('user_id', Auth::id())
            ->with('comic')
            ->orderBy('updated_at', 'desc')
            ->get();
        
        return response()->json($histories);
    }

    public function store(Request $request){
        $request->validate([
            'comic_id' => 'required|exists:komiks,id',
            'chapter_id' => 'required|exists:chapters,id',
        ]);

        $history = History::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'comic_id' => $request->comic_id,
            ],
            [
                'chapter_id' => $request->chapter_id,
                'updated_at' => now(),
            ]
        );

        return response()->json([
            'message' => 'History berhasil diupdate!',
            'data' => $history,
        ]);
    }
}

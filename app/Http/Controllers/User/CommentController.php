<?php

namespace App\Http\Controllers\User;

use App\Models\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'chapter_id' => 'required|exists:chapters,id',
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'chapter_id' => $request->chapter_id,
            'content' => $request->content,
        ]);

        return response()->json([
            'status' => 'success',
            'comment' => $comment->load('user')
        ]);
    }

    public function destroy($id){
        $comment = Comment::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $comment->delete();

        return response()->json([
            'status' => 'deleted'
        ]);
    }
}

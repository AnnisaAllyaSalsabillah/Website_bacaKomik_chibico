<?php

namespace App\Http\Controllers\User;

use App\Models\Upvote;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illmunate\Support\Facades\Auth;

class UpvoteController extends Controller
{
    public function toggle($id){
        $userId = Auth::id();

        $existing = Upvote::where('user_id', $userId)
            ->where('komik_id', $id)
            ->first();

        if($existing){
            $existing->delete();
            return response()->json([
                'status' => 'removed'
            ]);
        } else {
            Upvote::create([
                'user_id' => $userId,
                'komik_id' => $id,
            ]);
            return response()->json([
                'status' => 'added'
            ]);
        }
    }
}

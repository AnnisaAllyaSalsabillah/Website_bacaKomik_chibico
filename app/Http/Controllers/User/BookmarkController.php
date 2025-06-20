<?php

namespace App\Http\Controllers\User;

use App\Models\Bookmark;
use App\Models\Comic;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index(){
        $bookmarks = Bookmark::with('comic')
            ->where('user_id', Auth::user()->id)
            ->latest()
            ->get();

        return view('user.bookmarks.index', compact('bookmarks'));
    }

    public function toggle($id){
        $bookmark = Bookmark::where('user_id', Auth::id())
            ->where('komik_id', $id)
            ->first();
        
        if($bookmark){
            $bookmark->delete();
        } else {
            Bookmark::create([
                'user_id' => Auth::id(),
                'komik_id' => $id,
            ]);
        }

        return redirect()->back()->with('success', 'Bookmark berhasil diperbarui');
    }
}

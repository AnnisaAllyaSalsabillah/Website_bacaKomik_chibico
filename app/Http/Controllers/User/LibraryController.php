<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\History;
use App\Models\Bookmark;

class LibraryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $histories = History::with(['comic', 'chapter'])
            ->where('user_id', $user->id)
            ->orderByDesc('updated_at')
            ->get();

        $bookmarks = Bookmark::with('comic.genres')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return view('user.library.index', compact('histories', 'bookmarks'));
    }
}

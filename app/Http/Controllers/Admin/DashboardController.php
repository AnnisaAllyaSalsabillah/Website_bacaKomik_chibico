<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comic;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Upvote;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(){
        return view('admin.dashboard.index', [
            'totalComics' => Comic::count(),
            'totalChapters' => Chapter::count(),
            'totalUser' => User::count(),
            'totalComment' => Comment::count(),
            'topUpvoteComics' => Comic::withCount('upvotes')->orderBy('upvotes_count', 'desc')->take(5)->get()
        ]);
    }
}

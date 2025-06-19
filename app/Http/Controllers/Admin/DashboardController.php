<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comic;
use App\Models\Chapter;
use App\Models\Upvote;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalComics = Comic::count();
        $totalChapters = Chapter::count();
        $totalUser = User::count();
        $defaultComic = Comic::first();

        return view('admin.dashboard.dash', [
            'totalComics' => $totalComics,
            'totalChapters' => $totalChapters,
            'totalUser' => $totalUser,
            'defaultComic' => $defaultComic
        ]);
    }


    /**
     * 
     * 
     * @return array
     */
    

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDashboardStats()
    {
        return response()->json([
            'totalComics' => Comic::count(),
            'totalChapters' => Chapter::count(),
            'totalUsers' => User::count(),
            
        ]);
    }
}
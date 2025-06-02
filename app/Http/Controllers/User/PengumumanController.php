<?php

namespace App\Http\Controllers\User;

use App\Models\Pengumuman;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index(){
        $pengumuman = Pengumuman::latest()->get();
        return view('user.pengumuman.index', compact('pengumuman'));
    }

    public function show($id){
        $pengumuman = Pengumuman::findOrFail($id);
        return view('user.pengumuman.show', compact('pengumuman'));
    }
}

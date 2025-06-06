<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';
    protected $fillable = [
        'title',
        'content',
        'thumbnail',
        'date',
    ];

    public function scopeLatestFirst($query){
        return $query->orderBy('date', 'desc');
    }
}

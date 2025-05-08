<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{

    protected $fillable = ['name'];

    public function comic(){
        return $this->belongsToMany(Comic::class, 'comic_genre', 'genre_id', 'komik_id')->withTimestamps();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Comic extends Model
{
    protected $table = 'komiks';

    protected $fillable = [
        'title',
        'sinopsis',
        'cover_image',
        'rank',
        'alternative',
        'author',
        'artist',
        'type',
        'release_year',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($comic) {
            $comic->slug = Str::slug($comic->title);
        });
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'comic_genre', 'komik_id', 'genre_id');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'komik_id');
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function upvotes()
    {
        return $this->hasMany(Upvote::class, 'komik_id');
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    

}

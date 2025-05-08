<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = [
        'chapter',
        'title',
        'slug',
        'release_at',
    ];

    public static function boot(){
        parent::boot();
        static::creating(function($comic){
            $comic->slug = Str::slug($comic->title);
        });
    }

    public function comic(){
        return $this->belongsTo(Comic::class);
    }

    public function images(){
        return $this->hasMany(ChapterImage::class);
    }


}

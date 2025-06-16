<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ChapterImage extends Model
{
    protected $fillable = [
        'chapter_id',
        'image_path',
        'page_number',
        'file_id',
    ];

    public function chapter(){
        return $this->belongsTo(Chapter::class);
    }
}

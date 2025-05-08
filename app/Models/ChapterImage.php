<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ChapterImage extends Model
{
    protected $fillable = [
        'image_path',
        'page_number',
    ];

    public function chapter(){
        return $this->belongsTo(Chapter::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history'; // <-- ini penting!

    protected $fillable = [
        'user_id',
        'comic_id',
        'chapter_id',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);   
    }

    public function comic()
    {
        return $this->belongsTo(Comic::class, 'comic_id');
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }
}

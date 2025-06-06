<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comic(){
        return $this->belongsTo(Comic::class);
    }

    public function chapter(){
        return $this->belongsTo(Chapter::class);
    }
}

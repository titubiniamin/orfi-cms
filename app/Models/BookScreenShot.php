<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookScreenShot extends Model
{
    use HasFactory;
    protected $fillable = [
        'book_id',
        'screen_shot',
        'screen_shot_location',
        'page_number'
    ];

    public function book()
    {
        return $this->belongsTo('App\Models\Book');
    }

    public function annotations()
    {
        return $this->hasMany('App\Models\Annotation');
    }

    public function questions()
    {
        return $this->hasMany('App\Models\Question');
    }

    public function answers()
    {
        return $this->hasMany('App\Models\Answer');
    }


}

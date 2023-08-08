<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annotation extends Model
{
    use HasFactory;
    protected $fillable = [
        'x_coordinate',
        'y_coordinate',
        'height',
        'width',
        'cropped_image',
        'book_screen_shot_id',
        'book_id',
        'page_number',
        'group_id'
    ];

    public function screenshot()
    {
        return $this->belongsTo(BookScreenShot::class);
    }

    public function question()
    {
        return $this->hasOne( Question::class);
    }

    public function answer()
    {
        return $this->hasOne(Answer::class);
    }

    public function book()
    {
        return $this->belongsTo('App\Models\Book');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'screen_shot_location',
        'question',
        'annotation_id',
        'book_screen_shot_id',
        'book_id',
        'group_id',
        'annotated_question',
    ];

    public function answers()
    {
        return $this->hasMany('App\Models\Answer');
    }

    public function annotation()
    {
        return $this->belongsTo('App\Models\Annotation');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\Group');
    }

    public function book()
    {
        return $this->belongsTo('App\Models\Book');
    }

    public function screenshot()
    {
        return $this->belongsTo('App\Models\ScreenShot');
    }


}

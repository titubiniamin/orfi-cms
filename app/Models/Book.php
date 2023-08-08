<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasEvents;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory,HasEvents;
    protected $fillable = [
        'name',
        'subject_id',
        'book'
    ];

    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }

    public function screenshots()
    {
        return $this->hasMany('App\Models\BookScreenShot');
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

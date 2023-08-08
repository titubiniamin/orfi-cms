<?php

namespace App\Models;

use App\Http\Traits\DiffForHumansTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory,DiffForHumansTrait;

    protected $fillable = [
        'name'
    ];

    public function books()
    {
        return $this->hasMany('App\Models\Book');
    }

}

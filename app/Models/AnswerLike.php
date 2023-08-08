<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerLike extends Model
{
    use HasFactory;

    protected $connection = 'mysql_orfi_web';
    protected $table = 'answer_likes';

  protected $fillable = [
        'index_id',
        'user_id',
    ];
}

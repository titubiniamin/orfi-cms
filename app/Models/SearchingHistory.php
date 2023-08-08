<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchingHistory extends Model
{
    use HasFactory;

    protected $connection = 'mysql_orfi_web';
    protected $table = 'searching_histories';

    protected $fillable = [
        'user_id',
        'question',
    ];
}

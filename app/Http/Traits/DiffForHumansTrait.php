<?php

namespace App\Http\Traits;

use Carbon\Carbon;

trait DiffForHumansTrait
{
    public function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->diffForHumans() : $value;
    }

    public function getUpdatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->diffForHumans() : $value;
    }
}

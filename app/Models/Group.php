<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "parent_id",
        "book_id"
    ];

    /**
     * Get all of the children for the Group
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Group::class,'parent_id');
    }

    /**
     * Get the parent that owns the Group
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Group::class, 'parent_id');
    }

    public function questions()
    {
        return $this->hasMany('App\Models\Question','group_id');
    }

}

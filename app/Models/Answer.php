<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'screen_shot_location',
        'answer',
        'question_id',
        'annotation_id',
        'book_screen_shot_id',
        'book_id',
        'type',
        'group_id',
        'index_id',
        'index_name',
        'annotated_answer',
        'likes',
        'review'
    ];

    /**
     * @return BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * @return BelongsTo
     */
    public function annotation(): BelongsTo
    {
        return $this->belongsTo(Annotation::class);
    }

    /**
     * @return BelongsTo
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * @return BelongsTo
     */
    public function screenshot(): BelongsTo
    {
        return $this->belongsTo(BookScreenShot::class);
    }

}

<?php

namespace App\Observers;

use App\Models\Annotation;
use App\Models\Question;
use App\Models\Answer;
use App\Helper\PictureConversion;

class AnnotationObserver
{
//    use PictureConversion;
    /**
     * Handle the Annotation "created" event.
     *
     * @param  \App\Models\Annotation  $annotation
     * @return void
     */
 /*   public function created(Annotation $annotation)
    {
        $text = $this->getText(request()->imagebase64);
        switch ( request()->type ) {
            case 'question':
                Question::create([
                    'question' => $text ?? null,
                    'annotated_question' => $text ?? null,
                    'annotation_id' => $annotation->id,
                    'book_screen_shot_id' => $annotation->book_screen_shot_id,
                    'book_id' => request()->bookID,
                    'group_id' => request()->groupID,
                ]);
                break;

            case "diagram":
            case "answer":

                Answer::create([
                    'answer' => $text ?? null,
                    'annotated_answer' => $text ?? null,
                    'annotation_id' => $annotation->id,
                    'book_screen_shot_id' => $annotation->book_screen_shot_id,
                    'book_id' => request()->bookID,
                    'question_id' => request()->questionID,
                    'type' => request()->type,
                    'group_id' => request()->groupID,
                ]);
                break;

            default:
                echo "things";
        }

        // $request()->type,
        // $request()->questionID,
    }*/

    /**
     * Handle the Annotation "updated" event.
     *
     * @param  \App\Models\Annotation  $annotation
     * @return void
     */
    /*public function updated(Annotation $annotation)
    {
        $text = $this->getText(request()->imagebase64);
        switch ( request()->type ) {

            case 'question':
                $annotation->question->update([
                    'question' => $text ?? null,
                    'annotation_id' => $annotation->id,
                    'book_screen_shot_id' => $annotation->book_screen_shot_id,
                    'book_id' => request()->bookID,
                    'group_id' => request()->groupID,
                ]);
                break;

            case "diagram":
            case "answer":

                $annotation->answer->update([
                    'answer' => $text ?? null,
                    'annotation_id' => $annotation->id,
                    'book_screen_shot_id' => $annotation->book_screen_shot_id,
                    'book_id' => request()->bookID,
                    'question_id' => request()->questionID,
                    'type' => request()->type,
                    'group_id' => request()->groupID,
                ]);
                break;

            default:
                echo "things";
        }
    }*/

    /**
     * @param Annotation $annotation
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleted(Annotation $annotation)
    {
        return response()->json(['success'], 200);
    }

    /**
     * Handle the Annotation "restored" event.
     *
     * @param  \App\Models\Annotation  $annotation
     * @return void
     */
    public function restored(Annotation $annotation)
    {
        //
    }

    /**
     * Handle the Annotation "force deleted" event.
     *
     * @param  \App\Models\Annotation  $annotation
     * @return void
     */
    public function forceDeleted(Annotation $annotation)
    {
        //
    }

    public function deleting(Annotation $annotation)
    {
        if($annotation->question){
            $answers = $annotation->question->answers;
            if($answers->count() > 0){
                foreach ($answers as $key => $answer) {
                    $answer->annotation->delete();
                }
            }
        }
    }


}

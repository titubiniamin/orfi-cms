<?php

namespace App\Services;

use App\Helper\PictureConversion;
use App\Models\Annotation;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionAnswerService
{
    use PictureConversion;

    public function storeQuestionAnswer(Request $request, Annotation $annotation)
    {
        $text = $this->getBase64ImageToText($request->imagebase64);
        switch ($request->type) {
            case 'question':
                Question::create([
                    'question' => $text ?? null,
                    'annotated_question' => $text ?? null,
                    'annotation_id' => $annotation->id,
                    'book_screen_shot_id' => $annotation->book_screen_shot_id,
                    'book_id' => $request->bookID,
                    'group_id' => $request->groupID,
                ]);
                break;

            case "diagram":
            case "answer":

                Answer::create([
                    'answer' => $text ?? null,
                    'annotated_answer' => $text ?? null,
                    'annotation_id' => $annotation->id,
                    'book_screen_shot_id' => $annotation->book_screen_shot_id,
                    'book_id' => $request->bookID,
                    'question_id' => $request->questionID,
                    'type' => $request->type,
                    'group_id' => $request->groupID,
                ]);
                break;

            default:
                echo "things";
        }
    }

    public function updateQuestionAnswer(Request $request, Annotation $annotation)
    {
        $text = $this->getBase64ImageToText($request->imagebase64);
        switch ($request->type) {
            case 'question':
                $annotation->question->update([
                    'question' => $text ?? null,
                    'annotated_question' => $text ?? null,
                    'annotation_id' => $annotation->id,
                    'book_screen_shot_id' => $annotation->book_screen_shot_id,
                    'book_id' => $request->bookID,
                    'group_id' => $request->groupID,
                ]);
                break;

            case "diagram":
            case "answer":

                $annotation->answer->update([
                    'answer' => $text ?? null,
                    'annotated_answer' => $text ?? null,
                    'annotation_id' => $annotation->id,
                    'book_screen_shot_id' => $annotation->book_screen_shot_id,
                    'book_id' => $request->bookID,
                    'question_id' => $request->questionID,
                    'type' => $request->type,
                    'group_id' => $request->groupID,
                ]);
                break;

            default:
                echo "things";
        }
    }


    public function storeManualQuestionAnswer($data, Annotation $annotation)
    {
        switch ($data['type']) {
            case 'question':
                Question::create([
                    'question' => $data['text']  ?? null,
                    'annotated_question' => $data['text'] ?? null,
                    'annotation_id' => $annotation->id,
                    'book_screen_shot_id' => $annotation->book_screen_shot_id ?? null,
                    'book_id' => $data['book_id'],
                    'group_id' => $data['group_id'],
                ]);
                break;

            case "diagram":
            case "answer":
                Answer::create([
                    'answer' =>$data['text']  ?? null,
                    'annotated_answer' =>$data['text']  ?? null,
                    'annotation_id' => $annotation->id,
                    'book_screen_shot_id' => $annotation->book_screen_shot_id ?? null,
                    'book_id' =>  $data['book_id'],
                    'question_id' =>$data['question_id'],
                    'type' => $data['type'],
                    'group_id' => $data['group_id'],
                ]);
                break;

            default:
                echo "things";
        }
    }

    public function updateManualQuestionAnswer($request, Annotation $annotation)
    {
        switch ($request->type) {
            case 'question':
                $annotation->question->update([
                    'question' => $text ?? null,
                    'annotated_question' => $text ?? null,
                    'annotation_id' => $annotation->id,
                    'book_screen_shot_id' => $annotation->book_screen_shot_id,
                    'book_id' => $request->bookID,
                    'group_id' => $request->groupID,
                ]);
                break;

            case "diagram":
            case "answer":

                $annotation->answer->update([
                    'answer' => $text ?? null,
                    'annotated_answer' => $text ?? null,
                    'annotation_id' => $annotation->id,
                    'book_screen_shot_id' => $annotation->book_screen_shot_id,
                    'book_id' => $request->bookID,
                    'question_id' => $request->questionID,
                    'type' => $request->type,
                    'group_id' => $request->groupID,
                ]);
                break;

            default:
                echo "things";
        }
    }

}

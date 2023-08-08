<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Question;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public $list = '';
    public $book_id = null;

    public function __construct()
    {
        // $this->listview();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){}

    public function unansweredQuestions($questions)
    {
        $count = 0;
        foreach ($questions as $key => $question) {
            if($question->answers->count() == 0){
                $count++;
            }
        }
        return $count;
    }


    public function listview($parent_id = null)
    {
        $point_zero = Group::where('parent_id',$parent_id)->where('book_id',$this->book_id);

        if($point_zero->count() > 0 ){
            $point_zero = $point_zero->get();
            foreach ($point_zero as $key => $starting_point) {

                $data = "data-group-id= '".$starting_point->id."' data-group-parent-id='".$starting_point->parent_id."'";
                $view_all_question_answers_button = "<button title='View question & answer' ".$data." type='button' class='btn btn-tool text-primary show_question_button' ><i ".$data." class='fas fa-eye'></i></button>";
                $add_child_group_button = "<button title='Create new Group' onclick='changeAddGroupFormValue(this)'".$data." type='button' class='btn btn-tool text-primary' data-toggle='modal'><i ".$data." class='fas fa-plus'></i></button>";
                $edit_button = "<button title='Edit Group' onclick='changeEditGroupFormValue(this)'".$data." type='button' class='btn btn-tool text-primary' data-toggle='modal'><i ".$data." class='fas fa-pencil-alt'></i></button>";
                $delete_button = "<button title='Delete Group' onclick='changeDeleteGroupId(this)'".$data." type='button' class='btn btn-tool text-primary text-danger' data-toggle='modal'><i ".$data." class='fas fa-trash-alt'></i></button>";
                $add_question_button = "<button title='Create Annotation' ".$data." data-annotation-type='question' type='button' class='btn btn-tool text-primary text-danger annotation-type-button' ><i ".$data." data-annotation-type='question' class='fas fa-question'></i></button>";
                $add_manual_question_button = "<button title='Create Annotation manually' onclick='openAddQuestionAnswerModal(this)' ".$data." data-annotation-type='question' type='button' class='btn btn-tool text-info ' ><i ".$data." data-annotation-type='question' class='fa fa-question-circle'></i></button>";
                $count = "
                    <span class='badge badge-dark'>
                        ".$starting_point->questions->count()." Questions
                    </span>
                ";
                if($this->unansweredQuestions($starting_point->questions) > 0){
                    $count .= "<span class='badge badge-danger'>
                        ".$this->unansweredQuestions($starting_point->questions)." Unanswered questions
                    </span>";
                }
                $crud_button = "<span class='crud_button'>".$add_child_group_button.$edit_button.$delete_button.$add_manual_question_button.$add_question_button.$view_all_question_answers_button."</span> ".$count;
                // $add_question_answer_button = "<span class='add_question_answer_button'>".$add_question_button."</span>";

                $this->list .= $starting_point->children->count() > 0
                ? "<li
                    class='child-list'
                    id='li-elemtnt-".$starting_point->id."'
                    >
                        <span class='caret group_name caret-down' data-group-id=".$starting_point->id."  onclick='toggleOpen(this)' >".$starting_point->name."</span>".$crud_button.
                    "<ul id='ul-elemtnt-".$starting_point->id."' class='nested active'>"
                :   "<li class='child-list' id='li-elemtnt-".$starting_point->id."'>
                        <span class='group_name' onclick='toggleOpen(this)' >".$starting_point->name."</span>".$crud_button.
                    "</li>";
                $this->listview($starting_point->id);
            };
            $this->list .= "</ul></li>";
        }
    }

    public function getAllQnABygroup(Request $request)
    {
        $questions  = Question::where('book_id',$request->book_id)
                        ->where('group_id',$request->group_id)
                        ->get();
        $cards = $this->generateQuestionCard($questions);
        return response()->json([
            'questions' => $cards
        ],200);
    }

    public function generateQuestionCard($questions)
    {

        $questionsCard = '';
        foreach ($questions as $key => $question) {
            $data =
            'data-group-id = "'.$question->group_id.
            '"data-annotation-id ="'.$question->annotation_id.
            '"data-parent-card-id ="'."card-$question->id".
            '"data-question-id ="'."$question->id".
            '"data-is-question ="'.false.
            '"data-book-id ="'.$question->book_id.'"';
            $hasAnswer = $question->answers->count() > 0 ? '' : 'bg-danger text-white';
            $questionsCard .='
            <div class="card QnACard" id="card-'.$question->id.'">

              <div class="card-header" id="headingOne-'.$question->id.'">
                <h5 class="mb-0 card-title" style="width: 70%;">
                    <pre>'.$question->question.'</pre>
                </h5>
                <div class="card-tools">

                    <button title="Create annotation answer" '.$data.' data-annotation-type="answer" type="button" class="btn btn-tool annotation-type-button">
                        <i '.$data.' data-annotation-type="answer" class="fas fa-comment-dots"></i>
                    </button>

                     <button onclick="openAddQuestionAnswerModal(this)" title="Create manual answer" '.$data.' data-annotation-type="answer" type="button" class="btn btn-tool create-manual-annotation-button">
                        <i '.$data.' data-annotation-type="answer" class="fas fa-check-circle"></i>

                    </button>

                    <button title="Create annotation diagram" data-annotation-type="diagram" '.$data.' type="button" class="btn btn-tool annotation-type-button">
                        <i data-annotation-type="diagram" '.$data.' class="fas fa-project-diagram"></i>
                    </button>

                    <button title="Delete Question" '.$data.' data-type="delete" type="button" class="btn btn-tool delete-annotation-button">
                        <i '.$data.' data-type="delete" class="fas fa-trash"></i>
                    </button>

                    <button title="Edit Question" '.$data.' data-type="edit" data-annotation-type="question" type="button" class="btn btn-tool annotation-type-button">
                        <i '.$data.' data-type="edit" data-annotation-type="question" class="fas fa-pen"></i>
                    </button>

                    <button title="Edit annotation text" '.$data.' type="button" class="btn btn-tool edit-annotation-text-button">
                        <i '.$data.' class="fa fa-edit"></i>
                    </button>

                    <button title="Show answer" '.$data.'
                        class="btn btn-sm btn-link '.$hasAnswer.'"
                        type="button"
                        data-toggle="collapse"
                        data-target="#collapseOne-'.$question->id.'"
                        aria-expanded="false"
                        aria-controls="collapseOne-'.$question->id.'"
                    >
                        <i class="fas fa-layer-group"></i>

                    </button>

                </div>
              </div>

              <div id="collapseOne-'.$question->id.'" class="collapse" aria-labelledby="headingOne-'.$question->id.'" data-parent="#accordionExample">
                <div class="card-body accordion" id="accordionExample-'.$question->id.'">
                <pre>'.$question->$question.'</pre><br/><br/>
                '.$this->generateAnswerCard($question->answers).'
                </div>
              </div>

            </div>
            ';

        }
        return $questionsCard;

    }

    public function generateAnswerCard($answers)
    {
        $answersCard = '';
        $plusButton = '
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-plus"></i>
        </button>';

        if($answers->count() > 0){

            foreach ($answers as $key => $answer) {
                $data =
                'data-group-id = "'.$answer->group_id.
                '"data-annotation-type= "'.$answer->type.
                '"data-annotation-id ="'.$answer->annotation_id.
                '"data-question-id ="'.$answer->question_id.
                '"data-parent-card-id ="'."card-$answer->question_id$answer->id".
                '"data-book-id ="'.$answer->book_id.'"';


                $answersCard .='
                <div class="card QnACard" id="card-'.$answer->question_id.$answer->id.'">

                    <div class="card-header" id="headingOne-'.$answer->question_id.$answer->id.'">
                        <h5 class="mb-0 card-title" style="width:70%">
                            <pre>'.$answer->answer.'</pre>
                        </h5>
                        <div class="card-tools">
                            <button '.$data.' data-type="delete" type="button" class="btn btn-tool delete-annotation-button">
                                <i '.$data.' data-type="delete" class="fas fa-trash"></i>
                            </button>
                            <button '.$data.' data-type="edit" type="button" class="btn btn-tool annotation-type-button">
                                <i '.$data.' data-type="edit" class="fas fa-pen"></i>
                            </button>
                            <button '.$data.' type="button" class="btn btn-tool edit-annotation-text-button">
                                <i '.$data.' class="fas fa-edit"></i>
                            </button>
                            <button '.$data.'
                                class="btn btn-link"
                                type="button"
                                data-toggle="collapse"
                                data-target="#collapseOne-'.$answer->question_id.$answer->id.'"
                                aria-expanded="false"
                                aria-controls="collapseOne-'.$answer->question_id.$answer->id.'"
                            >
                                <i class="fas fa-layer-group"></i>
                            </button>
                        </div>

                    </div>

                    <div id="collapseOne-'.$answer->question_id.$answer->id.'" class="collapse" aria-labelledby="headingOne-'.$answer->question_id.$answer->id.'" data-parent="#accordionExample-'.$answer->question_id.'">
                        <div class="card-body">
                            <pre>'.$answer->answer.'</pre>
                        </div>
                    </div>

                </div>

                ';
            }
            return $answersCard;

        }

        return 'No answers found';
    }

    public function getAllGroup(Request $request)
    {
        $this->book_id = $request->book_id;
        $this->listview(null);
        return response()->json([
            'list' => $this->list,
            'data' => $request->book_id
        ],200);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     *
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $group = Group::Create($request->all());

        $data = "data-group-id= '".$group->id."' data-group-parent-id='".$group->parent_id."'";
        $view_all_question_answers_button = "<button ".$data." type='button' class='btn btn-tool text-primary show_question_button' ><i ".$data." class='fas fa-eye'></i></button>";
        $add_child_group_button = "<button onclick='changeAddGroupFormValue(this)'".$data." type='button' class='btn btn-tool text-primary' data-toggle='modal'><i ".$data." class='fas fa-plus'></i></button>";
        $edit_button = "<button onclick='changeEditGroupFormValue(this)'".$data." type='button' class='btn btn-tool text-primary' data-toggle='modal'><i ".$data." class='fas fa-pencil-alt'></i></button>";
        $delete_button = "<button onclick='changeDeleteGroupId(this)'".$data." type='button' class='btn btn-tool text-primary text-danger' data-toggle='modal'><i ".$data." class='fas fa-trash-alt'></i></button>";
        $add_question_button = "<button ".$data." data-annotation-type='question' type='button' class='btn btn-tool text-primary text-danger annotation-type-button' ><i ".$data." data-annotation-type='question' class='fas fa-question'></i></button>";

        $crud_button = "<span class='crud_button'>".$add_child_group_button.$edit_button.$delete_button.$add_question_button.$view_all_question_answers_button."</span>";
        $list = "<li class='child-list' id='li-elemtnt-".$group->id."'><span class='group_name' onclick='toggleOpen(this)' >".$group->name."</span>".$crud_button."</li>";

        return response()->json([
            'message' => 'successful',
            'list' => $list
        ],200);

    }

    /**
     * Display the specified resource.
     *
     * @param Group $group
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Group $group)
    {
        $parent = Group::where('id',$group->parent_id)->first();
        return response()->json([
            'data' => $group,
            'parent'=> $parent
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Group $group
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Group $group)
    {

        $group->update([
            "name" => $request->name,
            "parent_id" => $request->parent_id
        ]);

        return response()->json([
            'message'=> 'successful',
            'group' => $group
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Group $group
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return response()->json([
            'message' => 'successful'
        ],200);
    }
}

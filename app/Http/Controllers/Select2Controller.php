<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use App\Models\Subject;
use App\Models\Tag;
use App\Models\Group;

class Select2Controller extends Controller
{
    public function __construct()
    {

    }

    public function all_book_select_option(Request $request)
    {
        $data = [];
        if($request->searchTerm){
            $books = Book::where('name','LIKE',$request->searchTerm.'%' )->get();
            foreach ($books as $key => $book) {
                array_push($data,array(
                    'id' => $book->id,
                    'text' => $book->name,
                ));
            };
        }

        return json_encode($data);
    }

    public function all_tag_select_option(Request $request)
    {

        $data = [];
        if($request->searchTerm){

            $tags = Tag::where('name','LIKE',$request->searchTerm.'%' )->get();
            foreach ($tags as $key => $tag) {
                array_push($data,array(
                    'id' => $tag->id,
                    'text' => $tag->name,
                ));
            };
        }

        return json_encode($data);
    }

    public function all_subject_select_option(Request $request)
    {
        $data = [];
        if($request->searchTerm){
            $subjects = Subject::where('name','LIKE',$request->searchTerm.'%' )->get();
            foreach ($subjects as $key => $subject) {
                array_push($data,array(
                    'id' => $subject->id,
                    'text' => $subject->name,
                ));
            };
        };
        return json_encode($data);

    }

    public function all_group_select_option(Request $request)
    {
        $data = [];

        if($request->searchTerm){
            $book_id = $request->data;
            $subjects = Group::where('name','LIKE',$request->searchTerm.'%' )
                        ->where('book_id',$book_id)
                        ->get();

            foreach ($subjects as $key => $subject) {
                array_push($data,array(
                    'id' => $subject->id,
                    'text' => $subject->name,
                ));
            };

        };

        return json_encode($data);
    }
}

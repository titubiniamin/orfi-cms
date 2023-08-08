<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Subject;
use App\Models\Tag;
use Yajra\DataTables\DataTables;


class DatatablesController extends Controller
{

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllUser()
    {
        return Datatables::of(User::query()->latest())->addColumn('action', function ($user) {
            return '
            <div class="btn-group">
                <a href="' . route('user.edit', $user->id) . '" role="button" type="button" class="btn btn-default"><i class="fas fa-pencil-alt"></i></a>
                <a href="' . route('user.show', $user->id) . '" role="button" type="button" class="btn btn-default"><i class="fas fa-eye"></i></a>
                <a href="' . route('user.destroy', $user->id) . '" role="button" type="button" class="btn btn-default"><i class="fas fa-trash-alt"></i></a>
            </div>
            ';
        })->addColumn('image', function ($user) {
            return '<img height="50px" width="50px" src="' . $user->image . '" class="elevation-2" alt="User Image">';
        })->rawColumns(['image', 'action'])->make(true);
    }

    public function getAllBooks()
    {
        return Datatables::of(Book::query()->latest())->addColumn('action', function ($book) {
            return '
            <div class="btn-group">
                <a href="' . route('book.edit', $book->id) . '" role="button" type="button" class="btn btn-default"><i class="fas fa-pencil-alt"></i></a>
                <a href="' . route('annotation.edit', $book->id) . '" class="btn btn-default btn-sm float-right"><i class="fas fas fa-highlighter"></i></a>
                <form method="post" action="' . route('book.destroy', $book->id) . '">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <button role="button" type="submit" class="btn btn-default"><i class="fas fa-trash-alt"></i></button>
                </form>
            </div>
            ';
        })->addColumn('subject', function ($book) {
            return $book->subject->name;
        })->addColumn('tags', function ($book) {
            return $book->tags->pluck('name')->implode(', ');
        })->rawColumns(['action', 'subject'])->make(true);
    }

    public function getAllSubjects()
    {
        return Datatables::of(Subject::query()->latest())->addColumn('action', function ($subject) {
            return '
            <div class="btn-group">
                <a href="' . route('subject.edit', $subject->id) . '" role="button" type="button" class="btn btn-default"><i class="fas fa-pencil-alt"></i></a>
                <a href="' . route('subject.show', $subject->id) . '" role="button" type="button" class="btn btn-default"><i class="fas fa-eye"></i></a>
                <form method="post" action="' . route('subject.destroy', $subject->id) . '">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <button role="button" type="submit" class="btn btn-default"><i class="fas fa-trash-alt"></i></button>
                </form>
            </div>
            ';
        })->rawColumns(['action'])->make(true);
    }

    public function getAllTags()
    {
        return Datatables::of(Tag::query()->latest())->addColumn('action', function ($tag) {
            return '
            <div class="btn-group">
                <a href="' . route('tag.edit', $tag->id) . '" role="button" type="button" class="btn btn-default"><i class="fas fa-pencil-alt"></i></a>
                <a href="' . route('tag.show', $tag->id) . '" role="button" type="button" class="btn btn-default"><i class="fas fa-eye"></i></a>
                <form method="post" action="' . route('tag.destroy', $tag->id) . '">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <button role="button" type="submit" class="btn btn-default"><i class="fas fa-trash-alt"></i></button>
                </form>
            </div>
            ';
        })->rawColumns(['action'])->make(true);
    }

}

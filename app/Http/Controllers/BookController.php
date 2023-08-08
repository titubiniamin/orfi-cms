<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Subject;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Helper\CrudHelper;
use App\Http\Requests\BookRequest;
use App\Helper\PictureConversion;
use App\Models\BookScreenShot;

class BookController extends Controller
{
    public $crudhelper;
    use PictureConversion;

    public function __construct()
    {
        $this->crudhelper = new CrudHelper(new Book, 'Book', 'book.index');
    }

    /**
     * @return View
     */
    public function index()
    {
        $page_info = self::getPageInfo(['list']);
        return view('pages.books.index', compact('page_info'));
    }

    /**
     * @return View
     */
    public function create()
    {
        $page_info = self::getPageInfo(['create']);
        $tags = Tag::query()->latest()->get();
        $subjects = Subject::query()->latest()->get();
        return view('pages.books.create', compact('page_info', 'tags','subjects'));
    }


    public function store(BookRequest $request)
    {
        return $this->crudhelper->store($request, 'book');
    }

    /**
     * @param Book $book
     * @return View
     */
    public function show(Book $book)
    {
        $page_info = self::getPageInfo([$book->name]);
        return view('pages.books.create', compact('page_info', 'book'));
    }

    /**
     * @param Book $book
     * @return View
     */
    public function edit(Book $book)
    {
        $page_info = self::getPageInfo(['edit', $book->name]);
        $tags = Tag::query()->latest()->get();
        $subjects = Subject::query()->latest()->get();
        return view('pages.books.edit', compact('page_info', 'book', 'tags','subjects'));
    }

    /**
     * @param BookRequest $request
     * @param Book $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BookRequest $request, Book $book)
    {
        $book->tags()->detach($book->tags);
        $book->tags()->attach($request->tag);

        return $this->crudhelper->update($request, $book,'book');
    }

    /**
     * @param Book $book
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Book $book)
    {
        return $this->crudhelper->destroy($book,'book');
    }

    /**
     * @param array $newInfo
     * @return array
     */
    public function getPageInfo(array $newInfo = []): array
    {
        $page_info = [
            'title' => 'Book',
            'route' => 'book',
            'breadCrumb' => [
                'home',
                'book',
            ]
        ];
        foreach ($newInfo as $value) {
            $page_info['breadCrumb'][] = $value;
        }
        return $page_info;
    }


}

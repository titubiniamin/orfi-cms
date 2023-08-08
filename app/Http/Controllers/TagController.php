<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Helper\CrudHelper;
use App\Http\Requests\TagRequest;

class TagController extends Controller
{
    public $crudhelper;

    public function __construct()
    {
        $this->middleware('web');
        $this->crudhelper = new CrudHelper(new Tag, 'Tag','tag.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $page_info = self::getPageInfo(['list']);
        return view('pages.tags.index', compact('page_info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $page_info = self::getPageInfo(['create']);
        return view('pages.tags.create', compact('page_info'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TagRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(TagRequest $request)
    {
        return $this->crudhelper->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Tag $tag
     * @return View
     */
    public function show(Tag $tag)
    {
        $page_info = self::getPageInfo([$tag->name]);
        return view('pages.tags.show', compact('page_info', 'tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Tag $tag
     * @return View
     */
    public function edit(Tag $tag)
    {
        $page_info = self::getPageInfo(['edit',$tag->name]);
        return view('pages.tags.edit', compact('page_info', 'tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TagRequest $request
     * @param Tag $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TagRequest $request, Tag $tag)
    {
        return $this->crudhelper->update($request, $tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tag $tag
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Tag $tag)
    {
        return $this->crudhelper->destroy($tag, 'tag.index');
    }

    /**
     * @param array $newInfo
     * @return array
     */
    public function getPageInfo(array $newInfo = []): array
    {
        $page_info = [
            'title' => 'Tag',
            'route' => 'tag',
            'breadCrumb' => [
                'home',
                'tags',
            ]
        ];
        foreach ($newInfo as $value) {
            $page_info['breadCrumb'][] = $value;
        }
        return $page_info;
    }
}

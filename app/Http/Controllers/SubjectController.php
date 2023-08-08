<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Helper\CrudHelper;
use App\Http\Requests\SubjectRequest;

class SubjectController extends Controller
{
    public $crudhelper;

    public function __construct()
    {
        $this->crudhelper = new CrudHelper(new Subject, 'Subject','subject.index');
    }

    /**
     * @return View
     */
    public function index()
    {
        $page_info = self::getPageInfo(['list']);
        return view('pages.subjects.index', compact('page_info'));
    }

    /**
     * @return View
     *
     */
    public function create()
    {
        $page_info = self::getPageInfo(['create']);
        return view('pages.subjects.create', compact('page_info'));
    }

    /**
     * @param SubjectRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SubjectRequest $request)
    {
        return $this->crudhelper->store($request, 'subject.index');
    }

    /**
     * @param Subject $subject
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function show(Subject $subject)
    {
        $page_info = self::getPageInfo([$subject->name]);
        return view('pages.subjects.show', compact('page_info', 'subject'));
    }

    /**
     * @param Subject $subject
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function edit(Subject $subject)
    {
        $page_info = self::getPageInfo(['edit',$subject->name]);
        return view('pages.subjects.edit', compact('page_info', 'subject'));
    }

    /**
     * @param SubjectRequest $request
     * @param Subject $subject
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SubjectRequest $request, Subject $subject)
    {
        return $this->crudhelper->update($request, $subject);
    }

    /**
     * @param Subject $subject
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Subject $subject)
    {
        return $this->crudhelper->destroy($subject, 'subject.index');
    }

    /**
     * @param array $newInfo
     * @return array
     */
    public function getPageInfo(array $newInfo = []): array
    {
        $page_info = [
            'title' => 'Subject',
            'route' => 'subject',
            'breadCrumb' => [
                'home',
                'subject',
            ]
        ];
        foreach ($newInfo as $value) {
            $page_info['breadCrumb'][] = $value;
        }
        return $page_info;
    }
}

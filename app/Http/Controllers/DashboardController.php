<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        $page_info = self::getPageInfo();
        return view('pages.dashboard.index', compact('page_info'));
    }

    /**
     * @param array $newInfo
     * @return array
     */
    public function getPageInfo(array $newInfo = []): array
    {
        $page_info = [
            'title' => 'Dashboard',
            'route' => '',
            'breadCrumb' => [
                'home',
                'dashboard'
            ]
        ];
        foreach ($newInfo as $value) {
            $page_info['breadCrumb'][] = $value;
        }
        return $page_info;
    }
}

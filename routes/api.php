<?php

use App\Http\Controllers\ElasticSearchController;
use App\Http\Controllers\ScreenShotController;
use App\Http\Controllers\SearchingController;
use App\Http\Controllers\HistoryController;
use App\Models\OauthAccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::domain('orfi.com')->prefix('screenshot/get/')->group(function () {
//});

// this routes use for api searching.
Route::middleware('verify.api.token:10')->group(function () {
    Route::post('search-text-answer', [SearchingController::class, 'searchTextAnswer'])->name('screenshot.get.answer');
    Route::post('screenshot/get/text', [SearchingController::class, 'getImageText'])->name('screenshot.get.text');
    Route::post('search-image-answer', [SearchingController::class, 'searchAnswerFromImage']);
});

Route::post('increase-like', [ElasticSearchController::class, 'increaseLike']);
Route::get('search-suggestion', [SearchingController::class, 'getSearchSuggestion']);






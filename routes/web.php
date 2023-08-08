<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchingController;
use App\Http\Controllers\SocialAuthFacebookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScreenShotController;

use App\Http\Controllers\BookController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AnnotationController;
use App\Http\Controllers\DatatablesController;
use App\Http\Controllers\Select2Controller;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\GroupController;
use thiagoalessio\TesseractOCR\TesseractOCR;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});

Route::get('/test', function () {
    return view('test');
});

Route::post('/test', function () {
    $image = request()->file('file');
    $text = new TesseractOCR();
    $text->image($image->getRealPath());
    $text = $text->lang('eng','ben','equ');
    $text = $text->run();
    return $text;
//    return view('welcome');
})->name('test.store');

Route::get('/saveImage', [AnnotationController::class, 'saveImage']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('book', BookController::class);
    Route::resource('question', QuestionController::class);
    Route::resource('answer', AnswerController::class);
    Route::resource('group', GroupController::class);
    Route::resource('tag', TagController::class);
    Route::resource('annotation', AnnotationController::class);

    Route::post('store/manual-annotation', [AnnotationController::class, 'manualAnnotation'])->name('manual-annotation.store');

    Route::get('search', [ScreenShotController::class, 'searchForm'])->name('screenshot.search');
    Route::get('voicesearch', [ScreenShotController::class, 'voiceSearchForm'])->name('screenshot.voiceSearchForm');
    Route::post('search-text-answer', [SearchingController::class, 'searchTextAnswer'])->name('screenshot.get.answer');
    Route::post('screenshot/get/text', [ScreenShotController::class, 'getText'])->name('screenshot.get.text');
    Route::get('bulk/store/answer/{book}', [ScreenShotController::class, 'bulkStoreAnswer'])->name('bulk.store.answer');
    Route::resource('subject', SubjectController::class);
    Route::resource('screenshot', ScreenShotController::class);

});

Route::post('get/all/group', [GroupController::class, 'getAllGroup'])->name('get.all.group');
Route::get('/get/all/QnA/', [GroupController::class, 'getAllQnABygroup'])->name('get.all.QnA');

Route::delete('bookscreenshot/{bookscreenshot}', [BookController::class, 'pageDelete'])->name('delete.book.page');

Route::get('/pdf/{book}', [AnnotationController::class, 'pdftoimg'])->name('pdf.to.img');
Route::get('/get/annotation/text/{annotation}', [AnnotationController::class, 'getannotationText'])->name('get.annotation.text');

Route::get('/edit/annotation/text/{annotation}', [AnnotationController::class, 'editannotationText'])->name('edit.annotation.text');
Route::post('/update/annotation/text/{annotation}', [AnnotationController::class, 'updateannotationText'])->name('update.annotation.text');

Route::get('/ss', [AnnotationController::class, 'ss']);
Route::post('/ss/take', [AnnotationController::class, 'getScreenShotOfPDF']);

Route::get('/{book}/get/all/QnA', [AnnotationController::class, 'getAllQnA']);

Route::get('/bookscreenshot/annotation/{book}/{pagenumber}', [AnnotationController::class, 'getAllAnnotations']);

Route::get('all_book_select_option', [Select2Controller::class, 'all_book_select_option'])->name('get.book.select');
Route::get('all_subject_select_option', [Select2Controller::class, 'all_subject_select_option'])->name('get.subject.select');
Route::get('all_tag_select_option', [Select2Controller::class, 'all_tag_select_option'])->name('get.tag.select');
Route::get('all_group_select_option', [Select2Controller::class, 'all_group_select_option'])->name('get.groups.select');

Route::get('all_books', [DatatablesController::class, 'getAllBooks'])->name('allBooks');
Route::get('all_subjects', [DatatablesController::class, 'getAllSubjects'])->name('allSubjects');
Route::get('all_tags', [DatatablesController::class, 'getAllTags'])->name('allTags');


require __DIR__ . '/auth.php';




<?php

namespace App\Http\Controllers;

use App\Helper\PictureConversion;
use App\Http\Requests\StoreMenualAnnotationRequest;
use App\Models\Annotation;
use App\Services\FileUploadInCloud;
use App\Services\QuestionAnswerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AnnotationRequest;
use App\Models\Book;
use App\Models\BookScreenShot;
use App\Models\Question;
use App\Models\Group;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Vision\Feature;

class AnnotationController extends Controller
{
    use PictureConversion;

    public function saveImage()
    {
        $answer = \App\Models\Answer::first();

        $annotation = $answer->annotation;

        $base_64_image = $annotation->cropped_image;
        $book_name = strtolower(str_replace(' ', '_', $annotation->book->name));
        $type = $annotation->answer ? 'answer' : 'question';

        $image_name = $book_name . '_' . $type . '_annotation_id_' . $annotation->id . '.png';
        $path = 'storage\annotations\\' . $book_name;

        $data = substr($base_64_image, strpos($base_64_image, ',') + 1);
        $data = base64_decode($data);

        if (!\File::exists('storage\\' . $book_name . '\\' . $type)) {
            \File::makeDirectory('storage\\' . $book_name . '\\' . $type);
        }

        $path = 'storage\\' . $book_name . '\\' . $type;
        \File::put(public_path($path) . '\\' . $image_name, $data);

        return str_replace('/', '\\', asset($path . '\\' . $image_name));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $books = Book::simplePaginate(16);
        $page_info = [
            'title' => 'Annotations',
            'route' => 'annotation',
            'breadCrumb' => [
                'home',
                'book',
                'list'
            ]
        ];
        return view('pages.annotations.index', compact('page_info', 'books'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $page_info = [
            'title' => 'Annotations',
            'route' => 'annotation',
            'breadCrumb' => [
                'home',
                'book'
            ]
        ];

        return view('pages.annotations.create', compact('page_info'));
    }


    public function store(Request $request, QuestionAnswerService $questionAnswerService)
    {
        $imageName = 'annotation/' . 'annotation-' . Str::random(15) . time() . '.png';
        FileUploadInCloud::uploadBase64File($request->get('imagebase64'), $imageName);

        $book = Book::find($request->bookID);
        $page = $book->screenshots->where('page_number', (int)$request->pageNumber);

        if ($page->count() == 0) {
            $pageImageName = 'book/' . 'screen-shot-' . Str::random(15) . time() . '.png';
            FileUploadInCloud::uploadBase64File($request->get('pagebase64'), $pageImageName);
            $page = BookScreenShot::create([
                'book_id' => $request->bookID,
                'screen_shot' => $pageImageName,
                'screen_shot_location' => null,
                'page_number' => $request->pageNumber
            ]);
        } else {
            $page = $page->first();
        }


        $annotation = Annotation::create([
            'x_coordinate' => $request->CoordinateX,
            'y_coordinate' => $request->CoordinateY,
            'height' => $request->height,
            'width' => $request->width,
            'cropped_image' => $imageName,
            'book_screen_shot_id' => $page->id,
            'book_id' => $request->bookID,
            'page_number' => $request->pageNumber,
            'group_id' => $request->groupID
        ]);

        $questionAnswerService->storeQuestionAnswer($request, $annotation);


        return response()->json([
            'annotation' => $annotation,
            'message' => 'Annotation created successfully'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Annotation $annotation
     * @return \Illuminate\Http\Response
     */
    public function show(Annotation $annotation)
    {
        $page_info = [
            'title' => 'Annotations',
            'route' => 'annotation',
            'breadCrumb' => [
                'home',
                'book',
                'list'
            ]
        ];

        return view('pages.annotations.show', compact('page_info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Annotation $annotation
     * @return \Illuminate\Http\Response
     */
    public function edit($book_id)
    {
        $book = Book::find($book_id);
        $page_info = [
            'title' => 'Annotations',
            'route' => 'annotation',
            'breadCrumb' => [
                'home',
                'annotated',
                $book->name
            ]
        ];
        return view('pages.annotations.editv2', compact('page_info', 'book'));
    }

    /**
     * @param Request $request
     * @param $annotation
     * @return JsonResponse
     */
    public function update(Request $request, $annotation, QuestionAnswerService $questionAnswerService)
    {
        $book = Book::find($request->bookID);
        $page = $book->screenshots->where('page_number', (int)$request->pageNumber);

        $annotation = Annotation::find($annotation);
        $annotation_id = $annotation->id;

        if ($annotation) {
            if (Storage::disk('s3')->exists($annotation->cropped_image)) {
                Storage::disk('s3')->delete($annotation->cropped_image);
            }

            $imageName = 'annotation/' . 'annotation-' . Str::random(15) . time() . '.png';
            FileUploadInCloud::uploadBase64File($request->get('imagebase64'), $imageName);

            $annotation = $annotation->update([
                'x_coordinate' => $request->CoordinateX,
                'y_coordinate' => $request->CoordinateY,
                'height' => $request->height,
                'width' => $request->width,
                'cropped_image' => $imageName,
                'book_id' => $request->bookID,
                'group_id' => $request->groupID
            ]);
        }

        $questionAnswerService->updateQuestionAnswer($request, $annotation);

        return response()->json([
            'bookscreenshot' => $page,
            'annotation' => $annotation,
            'book' => $book,
            'update' => true
        ]);
    }

    /**
     * @param $annotation
     * @return JsonResponse
     */
    public function destroy(Annotation $annotation)
    {
        $book = $annotation->book;
        $annotation->delete();
        return response()->json([
            'message' => 'successfull',
            'book' => $book,
            'annotation' => $annotation->id
        ], 200);
    }

    public function ss()
    {
        return view('pages.annotations.ss');
    }

    public function getAnswer(Question $question)
    {
        $data = [];
        foreach ($question->answers as $key => $answer) {
            $data[] = [
                'id' => $answer->id,
                'image' => $answer->annotation->cropped_image,
                'annotationID' => $answer->annotation->id,
                'text' => $answer->answer,
                'type' => $answer->type,
                'iconname' => $answer->type == 'answer' ? 'comment-dots' : 'project-diagram'
            ];
        }

        return $data;
    }

    public function getAllQnA($book)
    {
        $book = Book::find($book);
        $questions = [];
        foreach ($book->questions as $key => $question) {
            $question = Question::find($question->id);
            $questions[] = [
                'id' => $question->id,
                'image' => $question->annotation->cropped_image,
                'text' => $question->question,
                'answers' => $this->getAnswer($question),
                'annotationID' => $question->annotation->id
            ];
        }

        return response()->json([
            'questions' => $questions
        ]);

    }


    public function getAllAnnotations(Book $book, $pagenumber)
    {
        $bookscreenshot = $book->screenshots->where('page_number', $pagenumber)->first();

        if ($bookscreenshot) {

            foreach ($bookscreenshot->annotations as $key => $annotation) {
                if ($annotation->question || $annotation->answer) {
                    $bookscreenshot->annotations[$key]->type = $annotation->question != null
                        ? 'question'
                        : $annotation->answer->type;
                }
            }

            return response()->json([
                'annotations' => $bookscreenshot->annotations,
            ], 200);
        }

        return response()->json([
            'annotations' => [],
        ], 200);

    }


    function getannotationText(Annotation $annotation)
    {

        $location = $annotation->cropped_image;
        $vision = new \Vision\Vision(
            env('GOOGLE_CLOUD_VISION_API_KEY'),
            [
                new Feature(Feature::DOCUMENT_TEXT_DETECTION, 100),
            ]
        );

        $response = $vision->request(
            new \Vision\Request\Image\LocalImage($location)
        );

        // dd($response);

        $text = $response->getfullTextAnnotation()->gettext();

        $image_path = '/' . 'storage/' . $location;

        if (\File::exists($image_path)) {
            \File::delete($image_path);
        }

        // dd($text);

        return \Response::json([
            "text" => $text
        ], 200);

    }

    public function editannotationText(Annotation $annotation)
    {
        $text = null;
        if ($annotation->answer) {
            $text = $annotation->answer->answer;
        } else {
            $text = $annotation->question->question;
        }

        return response()->json([
            'annotation' => $annotation,
            'text' => $text
        ]);
    }

    public function updateannotationText(Annotation $annotation, Request $request)
    {
        if ($annotation->answer) {
            $answer = $annotation->answer;
            $answer->answer = $request->previewText;
            $answer->save();
        } else {
            $question = $annotation->question;
            $question->question = $request->previewText;
            $question->save();
        }

        return response()->json([
            'request' => $request
        ], 200);
    }

    public function manualAnnotation(StoreMenualAnnotationRequest $request, QuestionAnswerService $questionAnswerService)
    {
        $address = null;
        $annotationText = null;
        if ($request->hasFile('image')) {
            $address = FileUploadInCloud::uploadFile($request->file('image'), "annotation");
            $annotationText = $this->getImageToText($request->file('image'));
        }

        $annotation = Annotation::create([
            'cropped_image' => $address,
            'book_id' => $request->book_id,
            'group_id' => $request->group_id
        ]);
        $data = $request->all();
        $data['text'] = $annotationText ?? $request->question_answer;

        $questionAnswerService->storeManualQuestionAnswer($data, $annotation);
        return response()->json([
            'annotation' => $annotation,
            'message' => "{$request->type} & Annotation created successfully"
        ], 200);
    }

}

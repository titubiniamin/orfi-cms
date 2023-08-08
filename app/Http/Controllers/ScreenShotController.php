<?php

namespace App\Http\Controllers;

use App\Helper\PictureConversion;
use App\Jobs\HistoryStore;
use App\Models\Book;
use App\Models\History;
use App\Models\ScreenShot;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use stdClass;
use Vision\Feature;
use Vision\Request\Image\LocalImage;
use Vision\Vision;

class ScreenShotController extends Controller
{
    use PictureConversion;

    protected $client;

    public function __construct()
    {
        // $hosts = ['localhost:9200'];
        $hosts = array(env('ELASTIC_SEARCH_HOST'));
        $builder = ClientBuilder::create();
        $builder->setHosts($hosts);
        $this->client = $builder->build();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $page_info = self::getPageInfo('list');

        return view('pages.screenShot.index', compact('page_info'));
    }


    public function searchForm()
    {
        return view('screenShot.search');
    }

    public function voiceSearchForm()
    {
        return view('screenShot.voice');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $page_info = self::getPageInfo('list');
        return view('pages.screenShot.create', compact('page_info'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $location = $request->image->store('storage', 'public');
        }

        $params = [
            'index' => 'ans',
            'id' => (string)Str::uuid(),
            'body' => [
                'question' => $request->text,
                'image' => $location,
            ]
        ];

        $response = $this->client->index($params);
        return redirect()->back();
    }

    public function searchAnswer(Request $request)
    {
        return self::searchFromElasticsearch($request->search_query, $request->page_number, $request->token);
    }

    public function searchFromElasticsearch($search_query, $page_number, $token)
    {
        $params = [
            'index' => 'question_answer',
            'body' => [
                'query' => [
                    'match' => [
                        'question' => [
                            'query' => $search_query,
                            "fuzziness" => 2,
                        ]
                    ]
                ],
                'size' => 5,
                'from' => $page_number ?? 0,
            ]
        ];

        $response = $this->client->search($params);
        return $response()->json(["result" => $response], 200);
    }



    public function bulkStoreAnswer(Book $book)
    {
        $answers = $book->answers;

        foreach ($answers as $answer) {
            if ($answer->index_id) {
                $this->client->delete(['index' => $answer->index_name, 'id' => $answer->index_id]);
            } else {
                $answer->index_id = (string) Str::uuid();
                $answer->index_name = 'question_answer';
                $answer->save();
            }

            $this->client->index([
                'index' => $answer->index_name,
                'id' => $answer->index_id,
                'body' => [
                    'annotated_question' => $answer->question->annotated_question,
                    'question' => $answer->question->question,
                    'annotated_answer' => $answer->annotated_answer,
                    'answer' => $answer->answer,
                    'question_image' => $answer->question->annotation->cropped_image,
                    'answer_image' => $answer->annotation->cropped_image,
                    'likes' => $answer->likes,
                    'review' => $answer->review,
                ]
            ]);

        }

        return redirect()->back();
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\ScreenShot $screenShot
     * @return \Illuminate\Http\Response
     */
    public function show(ScreenShot $screenShot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ScreenShot $screenShot
     * @return \Illuminate\Http\Response
     */
    public function edit(ScreenShot $screenShot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScreenShot $screenShot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ScreenShot $screenShot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ScreenShot $screenShot
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScreenShot $screenShot)
    {
        //
    }


    /**
     * @param $newInfo
     * @return array
     */
    public function getPageInfo($newInfo): array
    {
        $page_info = [
            'title' => 'screenshot',
            'route' => 'screenshot',
            'breadCrumb' => [
                'home',
                'screenshot',
            ]
        ];
        array_push($page_info['breadCrumb'], $newInfo);
        return $page_info;
    }

}

<?php

namespace App\Http\Controllers;

use App\Helper\PictureConversion;
use App\Http\Requests\SearchTextRequest;
use App\Jobs\HistoryStore;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchingController extends Controller
{

    use PictureConversion;

    protected $client;

    public function __construct()
    {
        $hosts = array(env('ELASTIC_SEARCH_HOST'));  // $hosts = ['localhost:9200'];
        $builder = ClientBuilder::create();
        $builder->setHosts($hosts);
        $this->client = $builder->build();
    }

    /**
     * @param SearchTextRequest $request
     * @return JsonResponse
     */
    public function searchTextAnswer(SearchTextRequest $request)
    {
        if ($request->filled('token') && $request->page_from < 0) HistoryStore::dispatch($request->search_query, $request->token);
        return self::textSearchFromElasticsearch($request->search_query, $request->page_from);
    }

    /**
     * @param $search_query
     * @param $page_from
     * @return JsonResponse
     */
    public function textSearchFromElasticsearch($search_query, $page_from)
    {
        $params = [
            'index' => 'question_answer',
            'body' => [
                'query' => [
                    'match' => [
                        'question' => [
                            'query' => $search_query,
                            "fuzziness" => "AUTO",
                        ]
                    ]
                ],
                'size' => 10,
                'from' => $page_from ?? 0,
            ]
        ];

        $response = $this->client->search($params);
        return response()->json([
            "result" => $response
        ], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchAnswerFromImage(Request $request)
    {
        $searchText = self::getBase64ImageToText($request->image);
        if ($request->filled('token')) HistoryStore::dispatch($searchText, $request->token);
        return self::imageSearchFromElasticsearch($searchText, 0);
    }

    /**
     * @param $search_query
     * @param $page_from
     * @return JsonResponse
     */
    public function imageSearchFromElasticsearch($search_query, $page_from)
    {
        $params = [
            'index' => 'question_answer',
            'body' => [
                'query' => [
                    'match' => [
                        'annotated_question' => [
                            'query' => $search_query,
                            "fuzziness" => "AUTO",
                        ]
                    ]
                ],
                'size' => 10,
                'from' => $page_from ?? 0,
            ]
        ];

        $response = $this->client->search($params);
        return response()->json([
            "result" => $response,
            'searchQuery' => $search_query
        ], 200);
    }

    /**
     * @param SearchTextRequest $request
     * @return JsonResponse
     */
    public function getSearchSuggestion(SearchTextRequest $request)
    {
        $params = [
            'index' => 'question_answer',
            'body' => [
                'query' => [
                    'bool' => [
                        'should' => [ // or condition
                            [
                                'match' => [
                                    'question' => [
                                        'query' => $request->search_query,
                                        "fuzziness" => "AUTO",
                                    ]
                                ],
                            ],
                            [
                                'wildcard' => [
                                    'question' => $request->search_query . '*',
                                ]
                            ]
                        ]
                    ]
                ],
                'size' => 6,
                'from' => 0,
            ]
        ];

        $response = $this->client->search($params);
        $results = array_map(function ($item) {
            return ['question' => $item['_source']['question']];
        }, $response['hits']['hits']);

        return response()->json(["results" => $results], 200);
    }
}

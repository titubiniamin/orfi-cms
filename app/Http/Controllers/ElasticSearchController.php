<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\AnswerLike;
use App\Models\OauthAccessToken;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;

class ElasticSearchController extends Controller
{
    protected $client;

    public function __construct()
    {
        $hosts = array(env('ELASTIC_SEARCH_HOST'));
        $builder = ClientBuilder::create();
        $builder->setHosts($hosts);
        $this->client = $builder->build();
    }

    public function increaseLike(Request $request)
    {
        $answerLike = AnswerLike::query();
        $userId = null;

        if ($request->filled('token')) {
            $userId = OauthAccessToken::query()->where('id', $request->token)->first()->user_id ?? null;
            $answer_like = $answerLike
                ->where('user_id', $userId)
                ->where('index_id', (String) $request->id)
                ->count();
            if ($answer_like) return response()->json(['message' => 'You have already liked this answer', 'status' => 400]);
            $answerLike->create(['user_id' => $userId, 'index_id' => $request->id]);
        }

        $params = [
            'index' => 'question_answer',
            'id' => $request->id,
            'body' => [
                'script' => [
                    "source" => "ctx._source.likes++",
                    "lang" => "painless"
                ],
            ],
        ];
        $this->client->update($params);
        Answer::query()->where('index_id', $request->id)->increment('likes');
        return response()->json(['message' => 'Like increased successfully', 'status' => 200]);
    }
}

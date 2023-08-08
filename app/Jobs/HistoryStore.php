<?php

namespace App\Jobs;

use App\Models\OauthAccessToken;
use App\Models\SearchingHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class HistoryStore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $search_query;
    private $token;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $search_query, string $token)
    {
        $this->search_query = $search_query;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = OauthAccessToken::query()->where('id', $this->token)->first();
        SearchingHistory::create([
            'user_id' => $user->user_id,
            'question' => $this->search_query,
        ]);

        Log::info('Searching History stored successfully.');
    }
}

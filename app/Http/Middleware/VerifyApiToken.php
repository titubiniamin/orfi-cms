<?php

namespace App\Http\Middleware;

use App\Models\OauthAccessToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VerifyApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $limits)
    {
        if ($request->filled('token') && $request->filled('sb_token')) {
            $tokenId = $request->token; // Passport auth token id.
            $sb_token = $request->sb_token; // Subscription token.
            $subscription = Cache::remember($tokenId, now()->addMinute(30), function () use ($tokenId, $sb_token) { // Cache the token for 30 minutes.
                $result = OauthAccessToken::find($tokenId);
                return $result ? $result->whereHas('subscription', function ($query) use ($sb_token) {
                    $query->where(['token' => $sb_token, 'status' => 'active'])->whereDate('expired_at', '>=', now());
                })->count() : 0;
            });
            if ($subscription) return $next($request);
            else return $this->checkLimits($request, $next, $limits);
        } else return $this->checkLimits($request, $next, $limits);
    }

    private function checkLimits(Request $request, Closure $next, $limits)
    {
        $isSearch = Cache::remember($request->ip(), now()->addDay(1), fn() => 0);
        if ($isSearch <= $limits) {
            Cache::increment($request->ip());
            return $next($request);
        } else {
            return response()->json(
                [
                    'message' => 'Today you have already use all trial searching. You can search again after 24 hour or buy any subscription plan.',
                    'status' => 429
                ]);
        }
    }
}



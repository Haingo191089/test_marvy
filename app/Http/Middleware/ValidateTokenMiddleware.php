<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Score;

class ValidateTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        $input = $request->all();
        $userId = $input[Score::USER_ID_COL] ?? 0;
        $gameId = $input[Score::GAME_ID_COL] ?? 0;
        $score = $input[Score::SCORE_COL] ?? 0;

        $hash = hash('sha256', "$userId::$gameId::$score::secret_key");
        if ($hash != $token) {
            $response = [
                STATUS => false,
                ERR_MSG => __('messages.msg5'),
                DATA => [],
            ];
    
            return response()->json($response);
        }
        return $next($request);
    }
}

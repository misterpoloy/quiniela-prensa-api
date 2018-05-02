<?php
/**
 * Created by PhpStorm.
 * User: josepharriaza
 * Date: 15/04/18
 * Time: 11:51 AM
 */

namespace App\Http\Middleware;

use App\UserTokens;
use Closure;

class AuthUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
        /*$api_key = $request->header()['api-key'];
        if ($api_key !== null) {

            $user_token = UserTokens::where('token', $api_key)->first();
            if ($user_token !== null) {
                return $next($request);
            }
        }

        return response()->json([
            'message' => 'Not authorized'
        ], 401);*/

    }
}
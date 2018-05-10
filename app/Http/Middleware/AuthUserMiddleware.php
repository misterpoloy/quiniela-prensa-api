<?php
/**
 * Created by PhpStorm.
 * User: josepharriaza
 * Date: 15/04/18
 * Time: 11:51 AM
 */

namespace App\Http\Middleware;

use App\UserTokens;
use App\AdministratorTokens;
use Closure;
use \Exception;

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
        //try {
            return $next($request);
        /*} catch (Exception $e) {
            return response()->json([
                'message' => 'Not authorized'
            ], 401);
        }*/
        return response()->json([
            'message' => 'Not authorized'
        ], 401);

    }
}
<?php

namespace App\Http\Middleware\Custom;

use App\Helpers\Errors;
use App\Helpers\HelperFunctions;
use App\Helpers\JwtDecoderHelper;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginStatusCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $SESSION_KEY_TOKEN = $request->bearerToken();



        /**JWT Authentications*/

        try {
            JWTAuth::setToken($SESSION_KEY_TOKEN); //<-- set token and check
            if (!$claim = JWTAuth::getPayload()) {

                return HelperFunctions::returnData(array(), false, Errors::$TOKEN_FORBIDDEN, 401, 40101, Errors::$TOKEN_FORBIDDEN);

            }else{

                return $next($request);

            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {


            return HelperFunctions::returnData(array(), false, Errors::$TOKEN_FORBIDDEN, 401, 40101, Errors::$TOKEN_FORBIDDEN);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return HelperFunctions::returnData(array(), false, Errors::$TOKEN_FORBIDDEN, 401, 40101, Errors::$TOKEN_FORBIDDEN);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return HelperFunctions::returnData(array(), false, Errors::$TOKEN_FORBIDDEN, 401, 40101, Errors::$TOKEN_FORBIDDEN);

        }


    }
}

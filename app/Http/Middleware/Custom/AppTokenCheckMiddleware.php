<?php

namespace App\Http\Middleware\Custom;

use App\Helpers\DefaultData;
use App\Helpers\Errors;
use App\Helpers\HelperFunctions;
use Closure;
use Illuminate\Http\Request;

class AppTokenCheckMiddleware
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
        /** @var $allHeaders Get All Headers */

        $allHeaders = $request->headers->all();

        /** Validate App Token in Header */

        if( isset( $allHeaders['x-api-key'] ) ){

            /** If token mismatch return */

            $app_token = $allHeaders['x-api-key'][0];

            if( strcmp( $app_token, DefaultData::$APP_TOKEN) == 0 ){

                return $next($request);

            }else{

                /** Return Error */
                return HelperFunctions::returnData(array(), false, Errors::$TOKEN_UNAUTHORIZED, 401, 40101, Errors::$TOKEN_UNAUTHORIZED);

            }

        }else{

            /** Return Error */
            return HelperFunctions::returnData(array(), false, Errors::$TOKEN_UNAUTHORIZED, 401, 40101, Errors::$TOKEN_UNAUTHORIZED);


        }
    }
}

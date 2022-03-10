<?php

namespace App\Http\Controllers\UserManagement;

use App\Helpers\Errors;
use App\Helpers\HelperFunctions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Claims\Expiration;
use Tymon\JWTAuth\Claims\IssuedAt;
use Tymon\JWTAuth\Claims\Issuer;
use Tymon\JWTAuth\Claims\JwtId;
use Tymon\JWTAuth\Claims\NotBefore;
use Tymon\JWTAuth\Claims\Subject;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Carbon\Carbon;
use Validator;
use Session;


class UserManagementController extends Controller
{

    /**
     * @OA\Post(
     *      path="/user/login",
     *      operationId="userLogin",
     *      tags={"User"},
     *      summary="Login User to System",
     *      description="Login user and get access token",
     *
     *      @OA\Parameter (
     *          parameter="x-api-key",
     *          name="x-api-key",
     *          description="Application Verification Token",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *          in="header",
     *          required=true
     *      ),
     *
     *
     *      @OA\RequestBody (
     *
     *              required = true,
     *              description = "Data packet for User Login",
     *              @OA\JsonContent(
     *                      type="object",
     *                      example={
     *
     *                          "username": "abcd",
     *                          "password": "123456",
     *
     *                               },
     *
     *              )
     *
     *     ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *                type="object",
     *               @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         example="Welcome"
     *               ),
     *              @OA\Property(
     *                         property="data",
     *                         type="object",
     *                         @OA\Property(
     *                              property="access_token",
     *                              type="string",
     *                              example="sample-token"
     *                         ),
     *               ),
     *
     *          )
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(
     *                type="object",
     *               @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         example="Invalid Credentials"
     *               ),
     *              @OA\Property(
     *                         property="userMessage",
     *                         type="string",
     *                         example="user Message"
     *               ),
     *              @OA\Property(
     *                         property="errorCode",
     *                         type="string",
     *                         example="error Code"
     *               ),
     *              @OA\Property(
     *                         property="metaData",
     *                         type="object",
     *                         example="error Code"
     *               ),
     *
     *
     *          )
     *      )
     *     )
     */

    public function userLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'username' => 'required|string',
            'password' => 'required|string',

        ]);

        if ($validator->fails()) {
            return HelperFunctions::validateRequest($validator);
        }

        try{

            $user=DB::table('users')
                ->where('username','=',$request->username)
                ->where('password','=',md5($request->password))
                ->first();

            if($user!=null){

                $dataForToken = [
                    'token_id' => $user->id,
                    'iss' => new Issuer('AP'),
                    'iat' => new IssuedAt(Carbon::now('UTC')),
                    'exp' => new Expiration(Carbon::now('UTC')->addDays(1)),
                    'nbf' => new NotBefore(Carbon::now('UTC')),
                    'sub' => new Subject('AP'),
                    'jti' => new JwtId('AP'),
                ];

                $customClaims = JWTFactory::customClaims($dataForToken);
                $payload = JWTFactory::make($dataForToken);
                $token = JWTAuth::encode($payload);

                $userToken = $token->get();


                session(['session_token' => $userToken]);

                $returnData = array(

                    "access_token" => $userToken,

                );

                return HelperFunctions::returnData($returnData, true, 'Welcome', 200);

            }else{

                return HelperFunctions::returnData(array(), false, Errors::$INVALID_LOGIN_CREDENTIALS, 403,40300,Errors::$INVALID_LOGIN_CREDENTIALS);

            }




        }catch (\Illuminate\Database\QueryException $e) {

            return HelperFunctions::returnData($e, false, Errors::$COMMON_DB_ERROR, 400,40000,Errors::$COMMON_DB_ERROR);

        }

    }
}

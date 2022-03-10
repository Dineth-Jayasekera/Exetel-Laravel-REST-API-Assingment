<?php

namespace App\Helpers;

class HelperFunctions
{
    public static function returnData($data, $success = true, $message = '', $code = 200, $errorCode=0,$userMessage='')
    {

        if($success){

            /**Success*/

            return response()->json([
                'message' => $message,
                'data' => $data
            ], $code);

        }else{

            /**Error*/

            return response()->json([
                'message' => $message,
                'userMessage' => $userMessage,
                'errorCode' => $errorCode,
                'metaData' =>$data
            ], $code);

        }

    }

    public static function validateRequest($validator)
    {

        /** @var Define Validate Errors */

        $validationErrors = $validator->errors()->getMessages();

        if (sizeof($validationErrors) > 0) {

            $returnData = array(

                'message' => $validationErrors,

            );

            /** Return Errors */

            return self::returnData($returnData, false, 'Something Went Wrong (Request Params Failed)',400,40000,'Request Params Failed');


        }
    }

}

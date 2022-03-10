<?php

namespace App\Http\Controllers\CustomerManagement;

use App\Helpers\Errors;
use App\Helpers\HelperFunctions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Validator;
use Session;

class CustomerManagementController extends Controller
{

    /**
     *
     *
     * @OA\Post(
     *      path="/customer/create",
     *      operationId="createCustomer",
     *      tags={"Customer"},
     *      summary="Create Customer In System",
     *      description="Create Customers",
     *      security={{"bearerAuth":{}}},
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
     *      @OA\RequestBody (
     *
     *              required = true,
     *              description = "Data packet for Customer Creation",
     *              @OA\JsonContent(
     *                      type="object",
     *                      example={
     *
     *                          "first_name": "Dineth",
     *                          "last_name": "Jayasekera",
     *                          "age": "24",
     *                          "dob": "1997-11-19",
     *                          "email": "dinethwa@gmail.com",
     *
     *                               },
     *
     *              )
     *
     *     ),
     *
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *                type="object",
     *               @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         example="Customer Created"
     *               ),
     *              @OA\Property(
     *                         property="data",
     *                         type="object",
     *
     *               ),
     *
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent(
     *                type="object",
     *               @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         example="Something Went Wrong on customer creation."
     *               ),
     *              @OA\Property(
     *                         property="userMessage",
     *                         type="string",
     *                         example="Something Went Wrong on customer creation."
     *               ),
     *              @OA\Property(
     *                         property="errorCode",
     *                         type="string",
     *                         example="error Code"
     *               ),
     *              @OA\Property(
     *                         property="metaData",
     *                         type="object",
     *
     *               ),
     *
     *
     *          )
     *      )
     *     )
     */

    public function createCustomer(Request $request)
    {


        $validator = Validator::make($request->all(), [

            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'age' => 'required|integer|min:1',
            'dob' => 'required|date|before:today|date_format:Y-m-d',
            'email' => 'required|email',

        ]);

        if ($validator->fails()) {
            return HelperFunctions::validateRequest($validator);
        }

        try {

            $customer = DB::table('customer')->insertGetId(
                array(
                    "first_name" => $request->first_name,
                    "last_name" => $request->last_name,
                    "age" => $request->age,
                    "dob" => $request->dob,
                    "email" => $request->email,
                    "creation_date" => date("Y-m-d h:i:s"),
                )
            );

            if ($customer != null) {

                return HelperFunctions::returnData([], true, 'Customer Created', 201);

            } else {

                return HelperFunctions::returnData(array(), false, Errors::$CUSTOMER_CREATION_ERROR, 400, 40000, Errors::$CUSTOMER_CREATION_ERROR);

            }

        } catch (\Illuminate\Database\QueryException $e) {

            return HelperFunctions::returnData($e, false, Errors::$COMMON_DB_ERROR, 400, 40000, Errors::$COMMON_DB_ERROR);

        }


    }

    /**
     *
     *
     * @OA\Get(
     *      path="/customer/get",
     *      operationId="getCustomers",
     *      tags={"Customer"},
     *      summary="Get All Customers In System",
     *      description="Get All Customers",
     *      security={{"bearerAuth":{}}},
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
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *                type="object",
     *               @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         example="All Customers"
     *               ),
     *              @OA\Property(
     *                         property="data",
     *                         type="array",
     *                         @OA\Items(
     *                              @OA\Property(
     *                                  property="first_name",
     *                                  type="string",
     *                                  example="Dineth"
     *                              ),
     *                              @OA\Property(
     *                                  property="id",
     *                                  type="string",
     *                                  example="1"
     *                              ),
     *                              @OA\Property(
     *                                  property="last_name",
     *                                  type="string",
     *                                  example="Jayasekera"
     *                              ),
     *                              @OA\Property(
     *                                  property="age",
     *                                  type="string",
     *                                  example="25"
     *                              ),
     *                              @OA\Property(
     *                                  property="date_of_birth",
     *                                  type="string",
     *                                  example="1997-11-19"
     *                              ),
     *                              @OA\Property(
     *                                  property="email",
     *                                  type="string",
     *                                  example="dinethwa@gmail.com"
     *                              ),
     *                              @OA\Property(
     *                                  property="creation_date",
     *                                  type="string",
     *                                  example="2022-03-10 11:19:2"
     *                              ),
     *                              @OA\Property(
     *                                  property="update_on",
     *                                  type="string",
     *                                  example="2022-03-10 11:19:2"
     *                              ),
     *                          )
     *
     *               ),
     *
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent(
     *                type="object",
     *               @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         example="Something Went Wrong on customer data receiving."
     *               ),
     *              @OA\Property(
     *                         property="userMessage",
     *                         type="string",
     *                         example="Something Went Wrong on customer data receiving."
     *               ),
     *              @OA\Property(
     *                         property="errorCode",
     *                         type="string",
     *                         example="error Code"
     *               ),
     *              @OA\Property(
     *                         property="metaData",
     *                         type="object",
     *
     *               ),
     *
     *
     *          )
     *      )
     *     )
     */

    public function getCustomers()
    {

        try {

            $customers = DB::table('customer')
                ->get();

            $all_customer = array();

            foreach ($customers as $customer) {
                $all_customer[] = array(
                    'id' => $customer->id,
                    'first_name' => $customer->first_name,
                    'last_name' => $customer->last_name,
                    'age' => $customer->age,
                    'date_of_birth' => $customer->dob,
                    'email' => $customer->email,
                    'creation_date' => $customer->creation_date,
                    'update_on' => $customer->update_on == null ? "" : $customer->update_on,
                );
            }

            if ($customer != null) {

                return HelperFunctions::returnData($all_customer, true, 'All Customers', 200);

            } else {

                return HelperFunctions::returnData(array(), false, Errors::$CUSTOMER_ALL_DATA_ERROR, 400, 40000, Errors::$CUSTOMER_ALL_DATA_ERROR);

            }

        } catch (\Illuminate\Database\QueryException $e) {

            return HelperFunctions::returnData($e, false, Errors::$COMMON_DB_ERROR, 400, 40000, Errors::$COMMON_DB_ERROR);

        }

    }


    /**
     *
     *
     * @OA\Put(
     *      path="/customer/update/{id}",
     *      operationId="updateCustomer",
     *      tags={"Customer"},
     *      summary="Update Customer In System",
     *      description="Update Customers",
     *      security={{"bearerAuth":{}}},
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
     *      @OA\Parameter (
     *          parameter="id",
     *          name="id",
     *          description="Customer ID",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *          in="path",
     *          required=true
     *      ),
     *
     *
     *      @OA\RequestBody (
     *
     *              required = true,
     *              description = "Data packet for Customer Updation",
     *              @OA\JsonContent(
     *                      type="object",
     *                      example={
     *
     *                          "first_name": "Dineth",
     *                          "last_name": "Jayasekera",
     *                          "age": "24",
     *                          "dob": "1997-11-19",
     *                          "email": "dinethwa@gmail.com",
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
     *                         example="Customer Updated"
     *               ),
     *              @OA\Property(
     *                         property="data",
     *                         type="object",
     *
     *               ),
     *
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent(
     *                type="object",
     *               @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         example="Something Went Wrong on customer updating."
     *               ),
     *              @OA\Property(
     *                         property="userMessage",
     *                         type="string",
     *                         example="Something Went Wrong on customer updating."
     *               ),
     *              @OA\Property(
     *                         property="errorCode",
     *                         type="string",
     *                         example="error Code"
     *               ),
     *              @OA\Property(
     *                         property="metaData",
     *                         type="object",
     *
     *               ),
     *
     *
     *          )
     *      )
     *     )
     */

    public function updateCustomer(Request $request, $id)
    {


        $validator = Validator::make($request->all(), [

            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'age' => 'required|integer|min:1',
            'dob' => 'required|date|before:today|date_format:Y-m-d',
            'email' => 'required|email',

        ]);

        if ($validator->fails()) {
            return HelperFunctions::validateRequest($validator);
        }

        try {

            $customer = DB::table('customer')
                ->where('id', '=', $id)
                ->update(
                    array(
                        "first_name" => $request->first_name,
                        "last_name" => $request->last_name,
                        "age" => $request->age,
                        "dob" => $request->dob,
                        "email" => $request->email,
                        "update_on" => date("Y-m-d h:i:s"),
                    )
                );

            if ($customer) {

                return HelperFunctions::returnData([], true, 'Customer Updated', 200);

            } else {

                return HelperFunctions::returnData(array(), false, Errors::$CUSTOMER_UPDATING_ERROR, 400, 40000, Errors::$CUSTOMER_UPDATING_ERROR);

            }

        } catch (\Illuminate\Database\QueryException $e) {

            return HelperFunctions::returnData($e, false, Errors::$COMMON_DB_ERROR, 400, 40000, Errors::$COMMON_DB_ERROR);

        }


    }


    /**
     *
     *
     * @OA\Delete (
     *      path="/customer/delete/{id}",
     *      operationId="deleteCustomer",
     *      tags={"Customer"},
     *      summary="Delete Customer In System",
     *      description="Delete Customers",
     *      security={{"bearerAuth":{}}},
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
     *      @OA\Parameter (
     *          parameter="id",
     *          name="id",
     *          description="Customer ID",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *          in="path",
     *          required=true
     *      ),
     *
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *                type="object",
     *               @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         example="Customer Deleted"
     *               ),
     *              @OA\Property(
     *                         property="data",
     *                         type="object",
     *
     *               ),
     *
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent(
     *                type="object",
     *               @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         example="Something Went Wrong on customer deletion."
     *               ),
     *              @OA\Property(
     *                         property="userMessage",
     *                         type="string",
     *                         example="Something Went Wrong on customer deletion."
     *               ),
     *              @OA\Property(
     *                         property="errorCode",
     *                         type="string",
     *                         example="error Code"
     *               ),
     *              @OA\Property(
     *                         property="metaData",
     *                         type="object",
     *
     *               ),
     *
     *
     *          )
     *      )
     *     )
     */

    public function deleteCustomer($id)
    {

        try {

            $customer = DB::table('customer')
                ->where('id', '=', $id)
                ->delete();

            if ($customer) {

                return HelperFunctions::returnData([], true, 'Customer Deleted', 200);

            } else {

                return HelperFunctions::returnData(array(), false, Errors::$CUSTOMER_DELETION_ERROR, 400, 40000, Errors::$CUSTOMER_DELETION_ERROR);

            }

        } catch (\Illuminate\Database\QueryException $e) {

            return HelperFunctions::returnData($e, false, Errors::$COMMON_DB_ERROR, 400, 40000, Errors::$COMMON_DB_ERROR);

        }


    }

}

<?php

namespace Tests\Feature;

use App\Helpers\DefaultData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerManagementTest extends TestCase
{

    private static $session_token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJBUCIsImlhdCI6MTY0NjkxMjkxNSwiZXhwIjoxNjQ2OTk5MzE1LCJuYmYiOjE2NDY5MTI5MTUsImp0aSI6IkFQIiwidG9rZW5faWQiOjEsInN1YiI6IkFQIn0.tT4HfksJ-hmkyCuCMc6tPDLIXRHNGFqMSZsteQLzHG0";
    private static $customer_id=0;

    /**
     * Test For Customer Creation with all required details.
     *
     * @return void
     */
    public function test_customer_creation_give_all_required_fields()
    {


        $response = $this->withHeaders([
            'x-api-key' => DefaultData::$APP_TOKEN,
            'Authorization' => 'Bearer ' . self::$session_token,
        ])->post('api/customer/create', [
            'first_name' => 'Testing Customer',
            'last_name' => 'Test',
            'age' => '25',
            'dob' => '1997-11-19',
            'email' => 'dinethwa@gmail.com',
        ]);

        $response->assertStatus(201);

    }

    /**
     * Test For Customer Creation with some required details.
     *
     * @return void
     */
    public function test_customer_creation_give_some_required_fields()
    {


        $response = $this->withHeaders([
            'x-api-key' => DefaultData::$APP_TOKEN,
            'Authorization' => 'Bearer ' . self::$session_token,
        ])->post('api/customer/create', [
            'first_name' => 'Testing Customer',
            'last_name' => 'Test',
            'email' => 'dinethwa@gmail.com',
        ]);

        $response->assertStatus(400);

    }


    /**
     * Test For get all customer details.
     *
     * @return void
     */
    public function test_all_customer_details()
    {

        $response = $this->withHeaders([
            'x-api-key' => DefaultData::$APP_TOKEN,
            'Authorization' => 'Bearer ' . self::$session_token,
        ])->get('api/customer/get');

        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                'message',
                'data'=>[
                    '*' => [
                        'id',
                        'first_name',
                        'last_name',
                        'age',
                        'date_of_birth',
                        'email',
                        'creation_date',
                        'update_on',
                    ]
                ]
            ]
        );

        $data=json_decode($response->getContent());
        self::$customer_id=$data->data[0]->id;

    }


    /**
     * Test For update customer details.
     *
     * @return void
     */
    public function test_update_customer()
    {

        $response = $this->withHeaders([
            'x-api-key' => DefaultData::$APP_TOKEN,
            'Authorization' => 'Bearer ' . self::$session_token,
        ])->put('api/customer/update/'.self::$customer_id,[
            'first_name' => 'Testing Customer',
            'last_name' => 'Update',
            'age' => '25',
            'dob' => '1997-11-19',
            'email' => 'dinethwa@gmail.com',
        ]);

        $response->assertStatus(200);

    }


    /**
     * Test For delete customer details.
     *
     * @return void
     */
    public function test_delete_customer()
    {

        $response = $this->withHeaders([
            'x-api-key' => DefaultData::$APP_TOKEN,
            'Authorization' => 'Bearer ' . self::$session_token,
        ])->delete('api/customer/delete/'.self::$customer_id);

        $response->assertStatus(200);


    }

}

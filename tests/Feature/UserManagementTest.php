<?php

namespace Tests\Feature;

use App\Helpers\DefaultData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserManagementTest extends TestCase
{

    /**
     * Test For Unauthorized Login.
     *
     * @return void
     */
    public function test_login_with_incorrect_credentials(){

        $response = $this->withHeaders([
            'x-api-key' => DefaultData::$APP_TOKEN,
        ])->post('api/user/login', ['username' => 'abcd1','password' => '123456']);

        $response->assertStatus(403);

    }

    /**
     * Test For Authorized Login.
     *
     * @return void
     */
    public function test_login_with_correct_credentials(){

        $response = $this->withHeaders([
            'x-api-key' => DefaultData::$APP_TOKEN,
        ])->post('api/user/login', ['username' => 'abcd','password' => '123456']);

        $response->assertStatus(200);

    }

}

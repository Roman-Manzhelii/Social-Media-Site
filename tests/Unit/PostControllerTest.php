<?php

/**
 * https://www.youtube.com/watch?v=UjA-16diixc
 * php artisan make:test PostControllerTest --unit
 */

namespace Tests\Unit;

use Tests\TestCase;

class PostControllerTest extends TestCase
{
    /**
     * HTTP Unit Test
     */
    public function test_example(){

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * HTTP Unit Test for Register
     */
    public function test_register(){

        $response = $this->post('/register',[
            'name' => 'Anton',
            'email' => 'anton@anton.com',
            'password' => 'testPASS77!',
            'password_confirmation' => 'testPASS77!'
        ]);

        $response->assertRedirect('/');

    }

}

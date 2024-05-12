<?php

/**
 * https://www.youtube.com/watch?v=UjA-16diixc
 * php artisan make:test PostControllerTest --unit
 * 
 * run single function (https://stackoverflow.com/questions/39118117/how-to-execute-specific-test-class-using-phpunit-in-laravel)
 * php artisan test --filter test_db_missing
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
     * Will fail if email is already in use
     */
    public function test_register(){

        $response = $this->post('/register',[
            'name' => 'anton',
            'email' => 'anton@susanton.com',
            'password' => 'testPASS77!',
            'password_confirmation' => 'testPASS77!'
        ]);

        $response->assertRedirect('/posts');

    }

    /**
     * This passes if tony is in the Database
     */
    public function test_db_for_tony(){

        $this->assertDatabaseHas('users',[
            'name' =>  'tony'
        ]);
    }

    /**
     * Passes if this user doesnt exist
     */
    public function test_db_missing(){

        $this->assertDatabaseMissing('users',[
            'name' => 'this_name_does_not_exist'
        ]);

    }

}

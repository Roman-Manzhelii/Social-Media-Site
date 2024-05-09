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

}

<?php

namespace Tests\Feature;

use Tests\TestCase;

class HelloTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/api/hello');

        $response->assertJson([
            "message" => "Hello from Sriflix API"
        ]);
        $response->assertStatus(200);
    }
}

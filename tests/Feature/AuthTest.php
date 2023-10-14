<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_success(): void
    {
        $user = [
            'username' => "user321",
            'password' => "654321"
        ];

        $response = $this->post('/api/auth/register', [
            "username" => $user['username'],
            "password" => $user['password']
        ]);

        $response->assertJson([
            "message" => "Success"
        ]);
        $response->assertStatus(201);

    }

    public function test_register_validation_failed(): void
    {
        $response = $this->post('/api/auth/register', [
            "username" => "",
            "password" => ""
        ]);

        $response->assertJsonStructure([
            "message"
        ]);
        $response->assertStatus(400);
    }

    public function test_register_username_exists(): void
    {
        $response = $this->post('/api/auth/register', [
            "username" => "user123",
            "password" => "123456"
        ]);

        $response->assertJson([
            "message" => "Username already exists"
        ]);
        $response->assertStatus(409);
    }

    public function test_login_success(): void
    {
        $response = $this->post('/api/auth/login', [
            "username" => "user123",
            "password" => "123456"
        ]);

        $response->assertJsonStructure(["message", "access_token"]);
        $response->assertStatus(200);
    }

    public function test_login_wrong_credentials(): void
    {
        $response = $this->post('/api/auth/login', [
            "username" => "user123",
            "password" => "xxxxxxxxxxxxxxx"
        ]);

        $response->assertJson(["message" => "Wrong credentials"]);
        $response->assertStatus(401);
    }

    public function test_get_me_success(): void
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "user123",
            "password" => "123456"
        ]);
        $response = $this->get('/api/auth/me', [
            "Authorization" => "Bearer " . $loginResponse['access_token']
        ]);

        $response->assertJsonStructure(["message", "user" => ["username"]]);
        $response->assertStatus(200);
    }


    public function test_get_me_unauthorized(): void
    {
        $response = $this->get('/api/auth/me', [
            "Accept" => "application/json"
        ]);

        $response->assertJson(["message" => "Unauthorized"]);
        $response->assertStatus(401);
    }

    protected function setUp(): void
    {
        parent::setUp();
        DB::table("users")->insert([
            "id" => "958f2234-bd68-4546-942d-ed1aaa535d33",
            "username" => "user123",
            "password" => Hash::make("123456")
        ]);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     */
    public function test_register_success()
    {
        $user = [
            'username' => $this->faker->userName,
            'password' => $this->faker->password(6, 10)
        ];

        $response = $this->post('/api/auth/register', [
            "username" => $user['username'],
            "password" => $user['password']
        ]);

        $response->assertJson([
            "message" => "Success"
        ]);
        $response->assertStatus(201);

        return $user;
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

    /**
     * @depends test_register_success
     */
    public function test_register_username_exists($user): void
    {
        $response = $this->post('/api/auth/register', [
            "username" => $user['username'],
            "password" => $user['password']
        ]);

        $response->assertJson([
            "message" => "Username already exists"
        ]);
        $response->assertStatus(409);
    }

    /**
     * @depends test_register_success
     */
    public function test_login_success($user): string
    {
        $response = $this->post('/api/auth/login', [
            "username" => $user['username'],
            "password" => $user['password']
        ]);

        $response->assertJsonStructure(["message", "access_token"]);
        $response->assertStatus(200);

        return $response["access_token"];
    }

    /**
     * @depends test_register_success
     */
    public function test_login_wrong_credentials($user): void
    {
        $response = $this->post('/api/auth/login', [
            "username" => $user['username'],
            "password" => "xxxxxxxxxxxxxxx"
        ]);

        $response->assertJson(["message" => "Wrong credentials"]);
        $response->assertStatus(401);
    }

    /**
     * @depends test_login_success
     */
    public function test_get_me_success($accessToken): void
    {
        $response = $this->get('/api/auth/me', [
            "Authorization" => "Bearer " . $accessToken
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
}

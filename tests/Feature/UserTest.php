<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanRegister()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password',
        ];

        $response = $this->post('/api/register', $userData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
        ]);
    }

    public function testUserCanLogin()
    {
        $user = \App\Models\User::factory()->create();

        $userData['email'] = $user->email;
        $userData['password'] = 'password';

        $response = $this->post('/api/login', $userData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => $user->id,
        ]);
    }

    public function testGetUserInformation()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get('/api/users/@me');

        $response->assertStatus(200);
    }
}

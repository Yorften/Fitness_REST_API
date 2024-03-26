<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Session;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SessionTest extends TestCase
{
    use RefreshDatabase;

    public function testSessionCanChangeStatus()
    {
        $user = User::factory()->create();
        $session = Session::factory()->create();

        $response = $this->actingAs($user)->patch('/api/sessions/' . $session->id . '/status');

        $response->assertStatus(200);
    }

    public function testCanGetAllSessions()
    {
        $users = User::factory(3)->create();
        $sessions = Session::factory(50)->create();

        $user = $users->first();

        /** @disregard P1006 works fine*/
        $response = $this->actingAs($user)->get('/api/sessions/');

        $response->assertStatus(200);

        $response->assertJsonCount($user->sessions()->count(), 'sessions');
    }

    public function testCanGetSession()
    {
        $users = User::factory(3)->create();
        $sessions = Session::factory(50)->create();

        $user = $users->first();
        
        $userSessions = $sessions->filter(function ($session) use ($user) {
            return $session->user_id === $user->id;
        });

        $id = $userSessions->pluck('id')->random();

        /** @disregard P1006 works fine*/
        $response = $this->actingAs($user)->get('/api/sessions/' . $id);

        $response->assertStatus(200);

        $response->assertJson([
            'session' => ['user_id' => $user->id]
        ]);
    }

    public function testCanStoreSession()
    {
        $user = User::factory()->create();

        $sessionData = [
            'name' => 'test',
            'weight' => '80',
            'height' => '1.80',
            'chest_measurement' => '180',
            'waist_measurement' => '140',
            'hips_measurement' => '150',
            'distance_run' => '3000',
        ];
        
        $response = $this->actingAs($user)->post('/api/sessions', $sessionData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('sessions', [
            'name' => $sessionData['name'],
            'weight' => $sessionData['weight'],
            'height' => $sessionData['height'],
            'chest_measurement' => $sessionData['chest_measurement'],
            'waist_measurement' => $sessionData['waist_measurement'],
            'hips_measurement' => $sessionData['hips_measurement'],
            'distance_run' => $sessionData['distance_run'],
        ]);
    }

    public function testCanUpdateSession()
    {
        $user = User::factory()->create();
        $session = Session::factory()->create();

        $sessionData = [
            'name' => 'test',
            'weight' => '80',
            'height' => '1.80',
            'chest_measurement' => '180',
            'waist_measurement' => '140',
            'hips_measurement' => '150',
            'distance_run' => '3000',
        ];
        
        $response = $this->actingAs($user)->put('/api/sessions/' . $session->id, $sessionData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('sessions', [
            'id' => $session->id,
            'name' => $sessionData['name'],
            'weight' => $sessionData['weight'],
            'height' => $sessionData['height'],
            'chest_measurement' => $sessionData['chest_measurement'],
            'waist_measurement' => $sessionData['waist_measurement'],
            'hips_measurement' => $sessionData['hips_measurement'],
            'distance_run' => $sessionData['distance_run'],
        ]);
    }
}

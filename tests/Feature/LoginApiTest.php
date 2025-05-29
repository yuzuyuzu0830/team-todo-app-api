<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginApiTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_login_successfully() {
        $user = User::factory()->create([
            'team_id' => 1,
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
            
    }

    public function test_login_with_wrong_password() {
        $user = User::factory()->create([
            'team_id' => 1,
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'wrong_password',
        ]);
        
        $response->assertStatus(422);

        $response->assertJson([
            'message' => '認証に失敗しました',
            'errors' => [
                'email' => ['認証に失敗しました']
            ]
        ]);
    }
}

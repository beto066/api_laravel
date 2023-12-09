<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Hash;

class LoginControllerTest extends TestCase
{
    use WithFaker;

    private string $email;
    private string $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->email = $this->faker->unique()->safeEmail();

        $this->user = User::factory()->create(['email' => $this->email, 'password' => Hash::make('password')]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginSucces()
    {
        $data = [
            'email' => $this->email,
            'password' => 'password',
        ];

        $response = $this->post('/api/login', $data);

        $response->assertJsonStructure([
            'token'
        ]);

        $response->assertStatus(200);
    }

    public function testLoginWithInvalidPassword() 
    {
        $data = [
            'email' => $this->email,
            'password' => 'password2',
        ];

        $response = $this->post('/api/login', $data);

        $response->assertStatus(422);
    }
}

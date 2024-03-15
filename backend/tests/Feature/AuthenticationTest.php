<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthenticationTest extends TestCase
{
    /**
     * Test try auth without credentials.
     *
     * @return void
     */
    public function testTryAuthWithoutCredentials(): void
    {
        $response = $this->json('POST', 'api/auth/', [], ['Accept' => 'application/json']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'password']);
        $response->assertJsonFragment([
            'email' => ['The email field is required.'],
            'password' => ['The password field is required.'],
        ]);
    }

    /**
     * Test try auth without email.
     *
     * @return void
     */
    public function testTryAuthWithoutEmail(): void
    {
        $response = $this->json('POST', 'api/auth/', ['password' => '12345'], ['Accept' => 'application/json']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
        $response->assertJsonFragment(['email' => ['The email field is required.']]);
    }

    /**
     * Test try auth with invalid email.
     *
     * @return void
     */
    public function testTryAuthWithInvalidEmail(): void
    {
        $response = $this->json(
            'POST',
            'api/auth/',
            ['email' => 'invalid_email', 'password' => '12345'],
            ['Accept' => 'application/json']
        );

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
        $response->assertJsonFragment(['email' => ['The email must be a valid email address.']]);
    }

    /**
     * Test try auth without password.
     *
     * @return void
     */
    public function testTryAuthWithoutPassword(): void
    {
        $response = $this->json('POST', 'api/auth/', ['email' => 'test@email.com'], ['Accept' => 'application/json']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
        $response->assertJsonFragment(['password' => ['The password field is required.']]);
    }

    /**
     * Test login successfully.
     *
     * @return void
     */
    public function testLoginSuccessfully(): void
    {
        $email = 'test@email.com';
        $password = '54321';

        User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        $response = $this->json(
            'POST',
            'api/auth/',
            [
                'email' => $email,
                'password' => $password
            ],
            ['Accept' => 'application/json']
        );

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token',
            'user' => [
                'id',
                'school_id',
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at',
            ],
        ]);
    }
}

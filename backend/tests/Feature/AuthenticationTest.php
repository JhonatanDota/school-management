<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthenticationTest extends TestCase
{
    /**
     * Test try auth without credentials.
     *
     * @return void
     */
    public function testTryAuthWithoutCredentials(): void
    {
        $response = $this->json('POST', 'api/auth/');

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
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
        $response = $this->json('POST', 'api/auth/', ['password' => '12345']);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
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
            ['email' => 'invalid_email', 'password' => '12345']
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
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
        $response = $this->json('POST', 'api/auth/', ['email' => 'test@email.com']);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['password']);
        $response->assertJsonFragment(['password' => ['The password field is required.']]);
    }

    /**
     * Test try auth with invaid credentials.
     *
     * @return void
     */
    public function testTryAuthWithInvalidCredentials(): void
    {
        $response = $this->json(
            'POST',
            'api/auth/',
            [
                'email' => 'test@email.com',
                'password' => '12345'
            ]
        );

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
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

        $user = User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        $response = $this->json(
            'POST',
            'api/auth/',
            [
                'email' => $email,
                'password' => $password
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
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
        $response->assertJsonFragment([
            'id' => $user->id,
            'school_id' => $user->school_id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    /**
     * Test try logout not logged.
     *
     * @return void
     */
    public function testTryLogoutNotLogged(): void
    {
        $response = $this->json('POST', 'api/logout/');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Test logout successfully.
     *
     * @return void
     */
    public function testLogoutSuccessfully(): void
    {
        $email = 'test@email.com';
        $password = '54321';

        User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        // Logging

        $loginResponse = $this->json(
            'POST',
            'api/auth/',
            [
                'email' => $email,
                'password' => $password
            ]
        );

        $loginResponse->assertStatus(Response::HTTP_OK);

        $token = $loginResponse['token'];

        // Access route logged

        $this->json('GET', 'api/teachers/', [], $this->authorization($token))->assertStatus(Response::HTTP_OK);

        // Logout

        $this->json('POST', 'api/logout/', [], $this->authorization($token))->assertStatus(Response::HTTP_OK);

        // Try access route after logout

        $this->json('GET', 'api/teachers/', [], $this->authorization($token))->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}

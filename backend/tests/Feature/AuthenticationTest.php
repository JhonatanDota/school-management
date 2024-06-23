<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\User;
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

        $response->assertUnprocessable();
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

        $response->assertUnprocessable();
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

        $response->assertUnprocessable();
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

        $response->assertUnprocessable();
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

        $response->assertUnauthorized();
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

        $response->assertOk();
        $response->assertJsonStructure(['token']);
    }

    /**
     * Test try logout not logged.
     *
     * @return void
     */
    public function testTryLogoutNotLogged(): void
    {
        $response = $this->json('POST', 'api/logout/');
        $response->assertUnauthorized();
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

        $loginResponse->assertOk();

        $token = $loginResponse['token'];

        // Access route logged

        $this->json('GET', 'api/teachers/', [], $this->authorization($token))->assertOk();

        // Logout

        $this->json('POST', 'api/logout/', [], $this->authorization($token))->assertOk();

        // Try access route after logout

        $this->json('GET', 'api/teachers/', [], $this->authorization($token))->assertUnauthorized();
    }
}

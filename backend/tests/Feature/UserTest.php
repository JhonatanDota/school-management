<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\User;

class UserTest extends TestCase
{
    private User $user;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * Test try access user routes not logged.
     *
     * @return void
     */
    public function testTryAccessUserRoutesNotLogged(): void
    {
        $this->json('GET', 'api/me/')->assertUnauthorized();
    }

    /**
     * Test me route.
     *
     * @return void
     */
    public function testMeRoute(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('GET', 'api/me/');

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'school_id',
            'name',
            'email',
            'user_type',
            'created_at',
            'updated_at',
        ]);
        $response->assertJsonFragment([
            'id' => $response['id'],
            'school_id' => $response['school_id'],
            'name' => $response['name'],
            'email' => $response['email'],
            'user_type' => $response['user_type'],
            'created_at' => $response['created_at'],
            'updated_at' => $response['updated_at'],
        ]);
        $this->assertArrayNotHasKey('password', $response);
        $this->assertArrayNotHasKey('remember_token', $response);
        $this->assertArrayNotHasKey('email_verified_at', $response);
    }
}

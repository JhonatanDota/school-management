<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\User;
use App\Models\Teacher;
use App\Models\School;

class TeacherTest extends TestCase
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
     * Test try access teacher routes not logged.
     *
     * @return void
     */
    public function testTryAccessTeacherRoutesNotLogged(): void
    {
        $fakeId = 1;

        $this->json('GET', 'api/teachers/')->assertStatus(401);
        $this->json('POST', 'api/teachers/')->assertStatus(401);
        $this->json('GET', "api/teachers/$fakeId/")->assertStatus(401);
        $this->json('PATCH', "api/teachers/$fakeId/")->assertStatus(401);
    }

    /**
     * Test check user can`t see teachers from another school.
     *
     * @return void
     */
    public function testCheckUserCantSeeTeachersFromAnotherSchool(): void
    {
        $this->actingAs($this->user);

        Teacher::factory()->count(3)->create();

        $response = $this->json('GET', 'api/teachers/');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'data' => [],
            'total' => 0,
        ]);
    }

    /**
     * Test get teachers.
     *
     * @return void
     */
    public function testGetTeachers(): void
    {
        $this->actingAs($this->user);

        $teachers = Teacher::factory(['school_id' => $this->user->school_id])->count(3)->create();
        Teacher::factory()->count(1)->create();

        $response = $this->json('GET', 'api/teachers/');

        $response->assertStatus(200);
        $response->assertJsonFragment(['total' => $teachers->count()]);
        $response->assertJsonCount($teachers->count(), 'data');
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'school_id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);
    }
}

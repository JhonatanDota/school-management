<?php

namespace Tests\Feature;

use Tests\TestCase;


use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Response;

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
        $unauthorizedStatus = Response::HTTP_UNAUTHORIZED;

        $this->json('GET', 'api/teachers/')->assertStatus($unauthorizedStatus);
        $this->json('POST', 'api/teachers/')->assertStatus($unauthorizedStatus);
        $this->json('GET', "api/teachers/$fakeId/")->assertStatus($unauthorizedStatus);
        $this->json('PATCH', "api/teachers/$fakeId/")->assertStatus($unauthorizedStatus);
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

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
            'data' => [],
            'total' => 0,
        ]);
    }

    /**
     * Test get teachers in same school.
     *
     * @return void
     */
    public function testGetTeachersSameSchool(): void
    {
        $this->actingAs($this->user);

        $teachers = Teacher::factory(['school_id' => $this->user->school_id])->count(3)->create();
        Teacher::factory()->count(1)->create();

        $response = $this->json('GET', 'api/teachers/');

        $response->assertStatus(Response::HTTP_OK);
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

    /**
     * Test check user can`t see teacher from another school.
     *
     * @return void
     */
    public function testCheckUserCantSeeTeacherFromAnotherSchool(): void
    {
        $this->actingAs($this->user);

        $teacher = Teacher::factory()->create();

        $response = $this->json('GET', "api/teachers/$teacher->id/");

        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $response->assertJsonFragment(['message' => 'This action is unauthorized.']);
    }

    /**
     * Test get teacher in same school.
     *
     * @return void
     */
    public function testGetTeacherSameSchool(): void
    {
        $this->actingAs($this->user);

        $teacher = Teacher::factory(['school_id' => $this->user->school_id])->create();

        $response = $this->json('GET', "api/teachers/$teacher->id/");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'id',
            'school_id',
            'name',
            'email',
            'created_at',
            'updated_at',
        ]);
    }
}

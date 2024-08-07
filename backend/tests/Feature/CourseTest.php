<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\User;
use App\Models\Course;

class CourseTest extends TestCase
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
     * Test try access course routes not logged.
     *
     * @return void
     */
    public function testTryAccessCourseRoutesNotLogged(): void
    {
        $this->json('GET', 'api/courses/')->assertUnauthorized();
    }

    /**
     * Test check user can`t see courses from another school.
     *
     * @return void
     */
    public function testCheckUserCantSeeCoursesFromAnotherSchool(): void
    {
        $this->actingAs($this->user);

        Course::factory()->count(3)->create();

        $response = $this->json('GET', 'api/courses/');

        $response->assertOk();
        $response->assertJsonFragment([
            'data' => [],
            'total' => 0,
        ]);
    }

    /**
     * Test get courses in same school.
     *
     * @return void
     */
    public function testGetCoursesSameSchool(): void
    {
        $this->actingAs($this->user);

        $courses = Course::factory(['school_id' => $this->user->school_id])->count(3)->create();
        Course::factory()->count(1)->create();

        $response = $this->json('GET', 'api/courses/');

        $response->assertOk();
        $response->assertJsonFragment(['total' => $courses->count()]);
        $response->assertJsonCount($courses->count(), 'data');
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'name',
                    'description',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);
    }

    /**
     * Test check user can`t see course from another school.
     *
     * @return void
     */
    public function testCheckUserCantSeeCourseFromAnotherSchool(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory()->create();

        $response = $this->json('GET', "api/courses/$course->id/");

        $response->assertForbidden();
        $response->assertJsonFragment(['message' => 'This action is unauthorized.']);
    }

    /**
     * Test get course.
     *
     * @return void
     */
    public function testGetCourse(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->create();

        $response = $this->json('GET', "api/courses/$course->id/");

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'name',
            'description',
            'created_at',
            'updated_at',
        ]);
    }
}

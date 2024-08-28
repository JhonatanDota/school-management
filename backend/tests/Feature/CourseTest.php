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

    /**
     * Test try create course without data.
     *
     * @return void
     */
    public function testTryCreateCourseWithoutData(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('POST', 'api/courses/');

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name']);
        $response->assertJsonFragment([
            'name' => ['The name field is required.'],
        ]);
    }

    /**
     * Test try create course without name.
     *
     * @return void
     */
    public function testTryCreateCourseWithoutName(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('POST', 'api/courses/', []);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name']);
        $response->assertJsonFragment([
            'name' => ['The name field is required.'],
        ]);
    }

    /**
     * Test create course successfully.
     *
     * @return void
     */
    public function testCreateCourseSuccessfully(): void
    {
        $this->actingAs($this->user);

        $name = 'Best course';
        $description = 'Learn everthing about php :)';

        $response = $this->json('POST', 'api/courses/', ['name' => $name, 'description' => $description]);

        $response->assertCreated();
        $response->assertJsonStructure([
            'id',
            'name',
            'description',
            'created_at',
            'updated_at',
        ]);
        $response->assertJsonFragment([
            'name' => $name,
            'description' => $description,
        ]);
    }

    /**
     * Test create course without description.
     *
     * @return void
     */
    public function testCreateCourseWithoutDescription(): void
    {
        $this->actingAs($this->user);

        $name = 'Best course';
        $response = $this->json('POST', 'api/courses/', ['name' => $name]);

        $response->assertCreated();
        $response->assertJsonFragment([
            'name' => $name,
            'description' => null,
        ]);
    }
}

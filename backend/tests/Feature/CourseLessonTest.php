<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\User;
use App\Models\Course;
use App\Models\CourseLesson;

class CourseLessonTest extends TestCase
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
     * Test try access course lessons routes not logged.
     *
     * @return void
     */
    public function testTryAccessCourseRoutesNotLogged(): void
    {
        $fakeId = 1;

        $this->json('POST', 'api/lessons/')->assertUnauthorized();
        $this->json('GET', "api/lessons/$fakeId/")->assertUnauthorized();
    }

    /**
     * Test try get unknown course lesson.
     *
     * @return void
     */
    public function testTryGetUnknownCourseLesson(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('GET', 'api/lessons/9999/');
        $response->assertNotFound();
    }

    /**
     * Test check user can`t see course lesson from another school.
     *
     * @return void
     */
    public function testCheckUserCantSeeCourseLessonFromAnotherSchool(): void
    {
        $this->actingAs($this->user);

        $courseLesson = CourseLesson::factory()->create();

        $response = $this->json('GET', "api/lessons/$courseLesson->id/");

        $response->assertForbidden();
        $response->assertJsonFragment(['message' => 'This action is unauthorized.']);
    }

    /**
     * Test get course lesson.
     *
     * @return void
     */
    public function testGetCourseLesson(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->create();
        $courseLesson = CourseLesson::factory(['course_id' => $course->id])->create();

        $response = $this->json('GET', "api/lessons/$courseLesson->id/");

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'name',
            'order',
            'created_at',
            'updated_at',
        ]);
    }
}

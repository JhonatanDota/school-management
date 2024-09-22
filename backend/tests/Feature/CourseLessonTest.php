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

    /**
     * Test try create course lesson without data.
     *
     * @return void
     */
    public function testTryCreateCourseLessonWithoutData(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('POST', 'api/lessons/', []);

        $expectedFieldErrors = ['course_id', 'name'];

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors($expectedFieldErrors);
        $response->assertJsonCount(count($expectedFieldErrors), 'errors');
        $response->assertJsonFragment([
            'course_id' => ['The course id field is required.'],
            'name' => ['The name field is required.'],
        ]);
    }

    /**
     * Test try create course lesson without course_id.
     *
     * @return void
     */
    public function testTryCreateCourseLessonWithoutCourseId(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('POST', 'api/lessons/', ['name' => 'Lesson 1']);

        $expectedFieldErrors = ['course_id'];

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors($expectedFieldErrors);
        $response->assertJsonCount(count($expectedFieldErrors), 'errors');
        $response->assertJsonFragment([
            'course_id' => ['The course id field is required.'],
        ]);
    }

    /**
     * Test try create course lesson without name.
     *
     * @return void
     */
    public function testTryCreateCourseLessonWithoutName(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->create();

        $response = $this->json('POST', 'api/lessons/', ['course_id' => $course->id]);

        $expectedFieldErrors = ['name'];

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors($expectedFieldErrors);
        $response->assertJsonCount(count($expectedFieldErrors), 'errors');
        $response->assertJsonFragment([
            'name' => ['The name field is required.'],
        ]);
    }

    /**
     * Test try create course lesson with course from another school.
     *
     * @return void
     */
    public function testTryCreateCourseLessonWithCourseFromAnotherSchool(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory()->create();

        $response = $this->json('POST', 'api/lessons/', ['course_id' => $course->id, 'name' => 'Lesson Name Teste']);

        $response->assertForbidden();

        $this->assertTrue($course->lessons->isEmpty());
    }

    /**
     * Test try create course lesson with too short name.
     *
     * @return void
     */
    public function testTryCreateCourseLessonWithTooShortName(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->create();

        $response = $this->json('POST', 'api/lessons/', ['course_id' => $course->id, 'name' => 'AB']);

        $expectedFieldErrors = ['name'];

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors($expectedFieldErrors);
        $response->assertJsonCount(count($expectedFieldErrors), 'errors');
        $response->assertJsonFragment([
            'name' => ['The name must be at least 3 characters.'],
        ]);
    }

    /**
     * Test try create course lesson with too long name.
     *
     * @return void
     */
    public function testTryCreateCourseLessonWithTooLongName(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->create();

        $response = $this->json('POST', 'api/lessons/', ['course_id' => $course->id, 'name' => str_repeat('Php', 10)]);

        $expectedFieldErrors = ['name'];

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors($expectedFieldErrors);
        $response->assertJsonCount(count($expectedFieldErrors), 'errors');
        $response->assertJsonFragment([
            'name' => ['The name must not be greater than 20 characters.'],
        ]);
    }

    /**
     * Test try create course lesson with order.
     *
     * @return void
     */
    public function testTryCreateCourseLessonWithOrder(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->create();

        $response = $this->json('POST', 'api/lessons/', ['course_id' => $course->id, 'name' => 'Php', 'order' => 1]);

        $expectedFieldErrors = ['order'];

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors($expectedFieldErrors);
        $response->assertJsonCount(count($expectedFieldErrors), 'errors');
        $response->assertJsonFragment([
            'order' => ['The order field is prohibited.'],
        ]);
    }

    /**
     * Test create course lesson.
     *
     * @return void
     */
    public function testCreateCourseLesson(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->create();

        $courseId = $course->id;
        $name = 'PHP - Part 1';
        $expectedOrder = 1;

        $response = $this->json('POST', 'api/lessons/', ['course_id' => $courseId, 'name' => $name]);

        $response->assertCreated();
        $response->assertJsonStructure([
            'id',
            'course_id',
            'name',
            'order',
            'created_at',
            'updated_at',
        ]);
        $response->assertJsonFragment([
            'course_id' => $courseId,
            'name' => $name,
            'order' => $expectedOrder,
        ]);
    }

    /**
     * Test course lesson order increase on creation.
     *
     * @return void
     */
    public function testCourseLessonOrderIncreaseOnCreation(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->create();

        $courseId = $course->id;

        $courseLessonResponse1 = $this->json('POST', 'api/lessons/', ['course_id' => $courseId, 'name' => 'PHP - Part 1']);
        $courseLessonResponse1->assertCreated();
        $courseLessonResponse1->assertJsonFragment([
            'order' => 1,
        ]);

        $courseLessonResponse2 = $this->json('POST', 'api/lessons/', ['course_id' => $courseId, 'name' => 'PHP - Part 2']);
        $courseLessonResponse2->assertCreated();
        $courseLessonResponse2->assertJsonFragment([
            'order' => 2,
        ]);

        $courseLessonResponse3 = $this->json('POST', 'api/lessons/', ['course_id' => $courseId, 'name' => 'PHP - Part 3']);
        $courseLessonResponse3->assertCreated();
        $courseLessonResponse3->assertJsonFragment([
            'order' => 3,
        ]);
    }
}

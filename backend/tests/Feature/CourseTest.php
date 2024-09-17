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
        $fakeId = 1;

        $this->json('GET', 'api/courses/')->assertUnauthorized();
        $this->json('POST', 'api/courses/')->assertUnauthorized();
        $this->json('GET', "api/courses/$fakeId/")->assertUnauthorized();
        $this->json('PATCH', "api/courses/$fakeId/")->assertUnauthorized();
    }

    /**
     * Test try get unknown course.
     *
     * @return void
     */
    public function testTryGetUnknownCourse(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', "api/courses/9999/");
        $response->assertNotFound();
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
     * Test try create course with too short name.
     *
     * @return void
     */
    public function testTryCreateCourseWithTooShortName(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('POST', 'api/courses/', ['name' => 'Php']);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name']);
        $response->assertJsonFragment([
            'name' => ['The name must be at least 5 characters.'],
        ]);
    }

    /**
     * Test try create course with too long name.
     *
     * @return void
     */
    public function testTryCreateCourseWithTooLongName(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('POST', 'api/courses/', ['name' => str_repeat('Php', 15)]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name']);
        $response->assertJsonFragment([
            'name' => ['The name must not be greater than 30 characters.'],
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

    /**
     * Test try update unknown course.
     *
     * @return void
     */
    public function testTryUpdateUnknownCourse(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', "api/courses/9999/");
        $response->assertNotFound();
    }

    /**
     * Test check user can`t update course from another school.
     *
     * @return void
     */
    public function testCheckUserCantUpdateCourseFromAnotherSchool(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory()->create();

        $response = $this->json('PATCH', "api/courses/$course->id/", ['name' => 'Another Course Name']);

        $response->assertForbidden();
        $response->assertJsonFragment(['message' => 'This action is unauthorized.']);
    }

    /**
     * Test can't update course school_id.
     *
     * @return void
     */
    public function testCantUpdateCourseSchoolId(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->create();

        $response = $this->json('PATCH', "api/courses/$course->id/");
        $response->assertOk();

        $responseUpdate = $this->json('PATCH', "api/courses/$course->id/", [
            'school_id' => 1
        ]);

        $responseUpdate->assertUnprocessable();
        $responseUpdate->assertJsonValidationErrors(['school_id']);
        $responseUpdate->assertJsonFragment([
            'school_id' => ['The school id field is prohibited.'],
        ]);
    }

    /**
     * Test try update course from another school.
     *
     * @return void
     */
    public function testTryUpdateCourseFromAnotherSchool(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory()->create();

        $response = $this->json('PATCH', "api/courses/$course->id/");
        $response->assertForbidden();
    }

    /**
     * Test try update course with too short name.
     *
     * @return void
     */
    public function testTryUpdateCourseWithTooShortName(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->create();

        $response = $this->json('PATCH', "api/courses/$course->id", ['name' => 'Php']);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name']);
        $response->assertJsonFragment([
            'name' => ['The name must be at least 5 characters.'],
        ]);
    }

    /**
     * Test try update course with too long name.
     *
     * @return void
     */
    public function testTryUpdateCourseWithTooLongName(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->create();

        $response = $this->json('PATCH', "api/courses/$course->id", ['name' => str_repeat('Php', 15)]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name']);
        $response->assertJsonFragment([
            'name' => ['The name must not be greater than 30 characters.'],
        ]);
    }

    /**
     * Test try update course with null name.
     *
     * @return void
     */
    public function testTryUpdateCourseWithNullName(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->create();

        $response = $this->json('PATCH', "api/courses/$course->id", ['name' => null]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name']);
        $response->assertJsonFragment([
            'name' => ['The name must be a string.', 'The name must be at least 5 characters.'],
        ]);
    }

    /**
     * Test update course name.
     *
     * @return void
     */
    public function testUpdateCourseName(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->create();

        $newName = 'Test course update';

        $response = $this->json('PATCH', "api/courses/$course->id/", [
            'name' => $newName,
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'description',
            'created_at',
            'updated_at',
        ]);

        $response->assertJsonFragment([
            'name' => $newName,
        ]);
    }

    /**
     * Test update course description.
     *
     * @return void
     */
    public function testUpdateCourseDescription(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->create();

        $newDescription = 'New Description';

        $response = $this->json('PATCH', "api/courses/$course->id/", [
            'description' => $newDescription,
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'description',
            'created_at',
            'updated_at',
        ]);

        $response->assertJsonFragment([
            'description' => $newDescription,
        ]);
    }

    /**
     * Test update course.
     *
     * @return void
     */
    public function testUpdateCourse(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->create();

        $newName = 'Test course update';
        $newDescription = 'nice course';

        $response = $this->json('PATCH', "api/courses/$course->id/", [
            'name' => $newName,
            'description' => $newDescription,
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'description',
            'created_at',
            'updated_at',
        ]);
        $response->assertJsonFragment([
            'name' => $newName,
            'description' => $newDescription,
        ]);
    }
}

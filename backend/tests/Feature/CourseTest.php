<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\User;
use App\Models\Course;
use App\Models\CourseLesson;

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
        $this->json('GET', "api/courses/$fakeId/lessons")->assertUnauthorized();
        $this->json('PATCH', "api/courses/$fakeId/")->assertUnauthorized();
        $this->json('PATCH', "api/courses/$fakeId/lessons-order")->assertUnauthorized();
    }

    /**
     * Test try get unknown course.
     *
     * @return void
     */
    public function testTryGetUnknownCourse(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('GET', "api/courses/9999/");
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
     * Test get course lessons without lessons.
     *
     * @return void
     */
    public function testGetCourseLessonsWithoutLessons(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->create();

        $response = $this->json('GET', "api/courses/$course->id/lessons");

        $response->assertOk();
        $response->assertJsonStructure([]);
        $response->assertJsonFragment([]);
    }

    /**
     * Test get course lessons.
     *
     * @return void
     */
    public function testGetCourseLessons(): void
    {
        $this->actingAs($this->user);

        $lessonsCount = 5;
        $course = Course::factory(['school_id' => $this->user->school_id])->hasLessons($lessonsCount)->create();

        $response = $this->json('GET', "api/courses/$course->id/lessons");

        $response->assertOk();
        $response->assertJsonCount($lessonsCount);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'course_id',
                'name',
                'order',
                'created_at',
                'updated_at',
            ]
        ]);
        $response->assertJsonFragment([
            'course_id' => $course->id,
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

    /**
     * Test try update course lessons orders passing an non array type to lessons field.
     *
     * @return void
     */
    public function testTryUpdateCourseLessonsOrdersPassingAnNonArrayTypeToLessonsField(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->create();

        $response = $this->json('PATCH', "api/courses/$course->id/lessons-order", [
            'orders' => 'string'
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['orders']);
        $response->assertJsonFragment([
            'orders' => ['The orders must be an array.', 'The orders must contain 0 items.'],
        ]);
    }

    /**
     * Test try update course lessons orders without pass orders array.
     *
     * @return void
     */
    public function testTryUpdateCourseLessonsOrdersWithoutPassOrdersArray(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->create();

        $response = $this->json('PATCH', "api/courses/$course->id/lessons-order");

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['orders']);
        $response->assertJsonFragment([
            'orders' => ['The orders field is required.'],
        ]);
    }

    /**
     * Test try update course lessons orders without pass all lessons ids.
     *
     * @return void
     */
    public function testTryUpdateCourseLessonsOrdersWithoutPassAllLessonsIds(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->hasLessons(3)->create();
        $lessons = $course->lessons;

        $response = $this->json('PATCH', "api/courses/$course->id/lessons-order", [
            'orders' => [$lessons->first()['id']]
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['orders']);
        $response->assertJsonFragment([
            'orders' => ['The orders must contain ' . $lessons->count() . ' items.'],
        ]);
    }

    /**
     * Test to verify the attempt to update course lesson orders when all IDs and orders are provided, 
     * but one of the IDs does not correspond to a valid lesson in the course.
     *
     * @return void
     */
    public function testTryUpdateCourseLessonOrderFailsWhenOneLessonIdIsInvalid(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->hasLessons(1)->create();
        $lesson = CourseLesson::factory()->create();

        $response = $this->json('PATCH', "api/courses/$course->id/lessons-order", [
            'orders' => [$lesson['id']]
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['orders.0']);
        $response->assertJsonFragment([
            'orders.0' => ['Some of the provided orders are either invalid or do not belong to this course.'],
        ]);
    }

    /**
     * Test update course lessons orders.
     *
     * @return void
     */
    public function testUpdateCourseLessonsOrders(): void
    {
        $this->actingAs($this->user);

        $course = Course::factory(['school_id' => $this->user->school_id])->hasLessons(5)->create();
        $lessons = $course->lessons;

        // Check current orders

        $response = $this->json('GET', "api/courses/$course->id/lessons");
        $responseData = $response->json();

        $response->assertOk();

        foreach ($responseData as $index => $lesson) {
            $this->assertEquals($lesson['order'], $index + 1);
            $this->assertEquals($lesson['id'], $lessons[$index]['id']);
            $this->assertEquals($lesson['order'], $lessons[$index]['order']);
        }

        // Revert lessons orders

        $response = $this->json('PATCH', "api/courses/$course->id/lessons-order", [
            'orders' => array_reverse($lessons->pluck('id')->toArray()),
        ]);

        $response->assertOk();

        // Check orders after changes

        $response = $this->json('GET', "api/courses/$course->id/lessons");
        $responseData = $response->json();

        foreach ($responseData as $index => $lesson) {
            $this->assertEquals($lesson['order'], $index + 1);
            $this->assertEquals($lesson['id'], $lessons[count($lessons) - ($index + 1)]['id']);
            $this->assertEquals($lesson['order'], $lessons[$index]['order']);
        }
    }
}

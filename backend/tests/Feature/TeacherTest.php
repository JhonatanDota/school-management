<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\User;
use App\Models\School;
use App\Models\Teacher;

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

        $this->json('GET', 'api/teachers/')->assertUnauthorized();
        $this->json('POST', 'api/teachers/')->assertUnauthorized();
        $this->json('GET', "api/teachers/$fakeId/")->assertUnauthorized();
        $this->json('PATCH', "api/teachers/$fakeId/")->assertUnauthorized();
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

        $response->assertOk();
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

        $response->assertOk();
        $response->assertJsonFragment(['total' => $teachers->count()]);
        $response->assertJsonCount($teachers->count(), 'data');
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'name',
                    'email',
                    'is_active',
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

        $response->assertForbidden();
        $response->assertJsonFragment(['message' => 'This action is unauthorized.']);
    }

    /**
     * Test try get unknown teacher.
     *
     * @return void
     */
    public function testTryGetUnknownTeacher(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('GET', "api/teachers/9999/");
        $response->assertNotFound();
    }

    /**
     * Test get teacher.
     *
     * @return void
     */
    public function testGetTeacher(): void
    {
        $this->actingAs($this->user);

        $teacher = Teacher::factory(['school_id' => $this->user->school_id])->create();

        $response = $this->json('GET', "api/teachers/$teacher->id/");

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'is_active',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * Test try create teacher without data.
     *
     * @return void
     */
    public function testTryCreateTeacherWithoutData(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('POST', 'api/teachers/');

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name', 'email']);
        $response->assertJsonFragment([
            'name' => ['The name field is required.'],
            'email' => ['The email field is required.'],
        ]);
    }

    /**
     * Test try create teacher without name.
     *
     * @return void
     */
    public function testTryCreateTeacherWithoutName(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('POST', 'api/teachers/', ['email' => 'user@teste.com']);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name']);
        $response->assertJsonFragment([
            'name' => ['The name field is required.'],
        ]);
    }

    /**
     * Test try create teacher without email.
     *
     * @return void
     */
    public function testTryCreateTeacherWithoutEmail(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('POST', 'api/teachers/', ['name' => 'User']);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['email']);
        $response->assertJsonFragment([
            'email' => ['The email field is required.'],
        ]);
    }

    /**
     * Test try create teacher with invalid email.
     *
     * @return void
     */
    public function testTryCreateTeacherWithInvalidEmail(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('POST', 'api/teachers/', ['name' => 'User', 'email' => 'invalid_email']);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['email']);
        $response->assertJsonFragment([
            'email' => ['The email must be a valid email address.'],
        ]);
    }

    /**
     * Test create teacher successfully.
     *
     * @return void
     */
    public function testCreateTeacherSuccessfully(): void
    {
        $this->actingAs($this->user);

        $name = 'User';
        $email = 'user@email.com';

        $response = $this->json('POST', 'api/teachers/', ['name' => $name, 'email' => $email]);

        $response->assertCreated();
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'is_active',
            'created_at',
            'updated_at',
        ]);
        $response->assertJsonFragment([
            'name' => $name,
            'email' => $email,
            'is_active' => true,
        ]);
    }

    /**
     * Test assert school_id is overwritten when create teacher.
     *
     * @return void
     */
    public function testSchoolIdOverwrittenWhenCreateTeacher(): void
    {
        $this->actingAs($this->user);

        $school = School::factory()->create();

        $response = $this->json('POST', 'api/teachers/', [
            'school_id' => $school->id,
            'name' => 'User',
            'email' => 'user@email.com'
        ]);

        $response->assertCreated();

        $teacherCreated = Teacher::find($response->json()['id']);

        $this->assertEquals(
            $teacherCreated->school_id,
            $this->user->school_id
        );
    }

    /**
     * Test check user can`t update teacher from another school.
     *
     * @return void
     */
    public function testCheckUserCantUpdateTeacherFromAnotherSchool(): void
    {
        $this->actingAs($this->user);

        $teacher = Teacher::factory()->create();

        $response = $this->json('PATCH', "api/teachers/$teacher->id/", ['name' => 'Another Name']);

        $response->assertForbidden();
        $response->assertJsonFragment(['message' => 'This action is unauthorized.']);
    }

    /**
     * Test can't update teacher school_id.
     *
     * @return void
     */
    public function testCantUpdateTeacherSchoolId(): void
    {
        $this->actingAs($this->user);

        $teacher = Teacher::factory(['school_id' => $this->user->school_id])->create();

        $response = $this->json('PATCH', "api/teachers/$teacher->id/");
        $response->assertOk();

        $responseUpdate = $this->json('PATCH', "api/teachers/$teacher->id/", [
            'school_id' => 1
        ]);

        $responseUpdate->assertUnprocessable();
        $responseUpdate->assertJsonValidationErrors(['school_id']);
        $responseUpdate->assertJsonFragment([
            'school_id' => ['The school id field is prohibited.'],
        ]);
    }

    /**
     * Test try update teacher with already used email.
     *
     * @return void
     */
    public function testTryUpdateTeacherWithAlreadyUsedEmail(): void
    {
        $this->actingAs($this->user);

        $email = 'test_same_email@test.com';
        Teacher::factory(['email' => $email])->create();

        $teacher = Teacher::factory()->create();

        $response = $this->json('PATCH', "api/teachers/$teacher->id/", [
            'email' => $email
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['email']);
        $response->assertJsonFragment([
            'email' => ['The email has already been taken.'],
        ]);
    }

    /**
     * Test try update teacher from another school.
     *
     * @return void
     */
    public function testTryUpdateTeacherFromAnotherSchool(): void
    {
        $this->actingAs($this->user);

        $teacher = Teacher::factory()->create();

        $response = $this->json('PATCH', "api/teachers/$teacher->id/");
        $response->assertForbidden();
    }

    /**
     * Test try update unknown teacher.
     *
     * @return void
     */
    public function testTryUpdateUnknownTeacher(): void
    {
        $this->actingAs($this->user);

        $response = $this->json('PATCH', "api/teachers/9999/");
        $response->assertNotFound();
    }

    /**
     * Test update teacher.
     *
     * @return void
     */
    public function testUpdateTeacher(): void
    {
        $this->actingAs($this->user);

        $teacher = Teacher::factory(['school_id' => $this->user->school_id])->create();

        $newName = 'Test new name';
        $newEmail = 'test_new_email@gmeil.new';

        $response = $this->json('PATCH', "api/teachers/$teacher->id/", [
            'name' => $newName,
            'email' => $newEmail,
            'is_active' => false,
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'is_active',
            'created_at',
            'updated_at',
        ]);
        $response->assertJsonFragment([
            'name' => $newName,
            'email' => $newEmail,
            'is_active' => false,
        ]);
    }
}

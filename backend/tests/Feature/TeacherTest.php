<?php

namespace Tests\Feature;

use Tests\TestCase;


use App\Models\User;
use App\Models\School;
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

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
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

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
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

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
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

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
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

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'id',
            'school_id',
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

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonFragment([
            'school_id' => $this->user->school_id
        ]);
    }
}

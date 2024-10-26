<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

use App\Repositories\CourseRepository;
use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Requests\UpdateCourseLessonsOrder;

class CourseController extends Controller
{
    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * Retrieve paginated Courses as JSON Response.
     *
     * @return JsonResponse
     */

    public function all(): JsonResponse
    {
        $schoolId = Auth::user()->school_id;
        return response()->json($this->courseRepository->all($schoolId));
    }

    /**
     * Create Course.
     *
     * @param CreateCourseRequest $request
     * @return JsonResponse
     */

    public function store(CreateCourseRequest $request): JsonResponse
    {
        $inputs = $request->validated();
        $inputs['school_id'] = Auth::user()->school_id;

        return response()->json($this->courseRepository->create($inputs), Response::HTTP_CREATED);
    }

    /**
     * Retrieve Course as JSON Response.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @param int $id
     * @return JsonResponse
     */

    public function show(int $id): JsonResponse
    {
        $course = $this->courseRepository->find($id);

        if (is_null($course)) return response()->json([], Response::HTTP_NOT_FOUND);

        $this->authorize('view', $course);

        return response()->json($course);
    }

    /**
     * Update Course.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @param int $id
     * @return JsonResponse
     */

    public function update(int $id, UpdateCourseRequest $request): JsonResponse
    {
        $course = $this->courseRepository->find($id);

        if (is_null($course)) return response()->json([], Response::HTTP_NOT_FOUND);

        $this->authorize('update', $course);

        return response()->json($this->courseRepository->update($course, $request->validated()));
    }

    /**
     * Retrieve Course Lessons as JSON Response.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @param int $id
     * @return JsonResponse
     */

    public function lessons(int $id): JsonResponse
    {
        $course = $this->courseRepository->find($id);

        if (is_null($course)) return response()->json([], Response::HTTP_NOT_FOUND);

        $this->authorize('view', $course);

        $lessons = $this->courseRepository->lessons($course);

        return response()->json($lessons);
    }

    /**
     * Reorder Course Lessons.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @param int $id
     * @return JsonResponse
     */

    public function lessonsOrder(int $id, UpdateCourseLessonsOrder $request): JsonResponse
    {
        $course = $this->courseRepository->find($id);

        if (is_null($course)) return response()->json([], Response::HTTP_NOT_FOUND);

        $this->authorize('update', $course);

        $this->courseRepository->updateCourseLessonsOrders([...$request->validated()['orders']]);

        return response()->json();
    }
}

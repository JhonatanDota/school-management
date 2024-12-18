<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

use App\Models\CourseLesson;
use App\Repositories\CourseRepository;
use App\Repositories\CourseLessonRepository;

use App\Http\Requests\CreateCourseLessonRequest;
use App\Http\Requests\UpdateCourseLessonRequest;

class CourseLessonController extends Controller
{
    private CourseRepository $courseRepository;
    private CourseLessonRepository $courseLessonRepository;

    public function __construct(CourseRepository $courseRepository, CourseLessonRepository $courseLessonRepository)
    {
        $this->courseRepository = $courseRepository;
        $this->courseLessonRepository = $courseLessonRepository;
    }

    /**
     * Create Course Lesson.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @param CreateCourseLessonRequest $request
     * @return JsonResponse
     */

    public function store(CreateCourseLessonRequest $request): JsonResponse
    {
        $inputs = $request->validated();

        $course = $this->courseRepository->find($inputs['course_id']);

        $this->authorize('create', [CourseLesson::class, $course]);

        return response()->json($this->courseLessonRepository->create($inputs), Response::HTTP_CREATED);
    }

    /**
     * Retrieve Course Lesson as JSON Response.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @param int $id
     * @return JsonResponse
     */

    public function show(int $id): JsonResponse
    {
        $courseLesson = $this->courseLessonRepository->find($id);

        if (is_null($courseLesson)) return response()->json([], Response::HTTP_NOT_FOUND);

        $this->authorize('view', $courseLesson);

        return response()->json($courseLesson);
    }

    /**
     * Update Course Lesson.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @param int $id
     * @return JsonResponse
     */

    public function update(int $id, UpdateCourseLessonRequest $request): JsonResponse
    {
        $courseLesson = $this->courseLessonRepository->find($id);

        if (is_null($courseLesson)) return response()->json([], Response::HTTP_NOT_FOUND);

        $this->authorize('update', $courseLesson);

        return response()->json($this->courseLessonRepository->update($courseLesson, $request->validated()));
    }
}

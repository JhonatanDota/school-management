<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CourseRepository;

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
     * Retrieve Course as JSON Response.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @param int $id
     * @return JsonResponse
     */

    public function show(int $id): JsonResponse
    {
        $course = $this->courseRepository->find($id);

        $this->authorize('view', $course);

        return response()->json($course);
    }
}

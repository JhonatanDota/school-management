<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\JsonResponse;
use App\Repositories\TeacherRepository;
use App\Http\Requests\CreateTeacherRequest;
use App\Http\Filters\TeacherFilter;

class TeacherController extends Controller
{
    private TeacherRepository $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * Retrieve paginated Teachers as JSON Response.
     *
     * @return JsonResponse
     */

    public function index(TeacherFilter $filter): JsonResponse
    {
        $schoolId = Auth::user()->school_id;
        return response()->json($this->teacherRepository->all($schoolId, $filter));
    }

    /**
     * Retrieve Teacher as JSON Response.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @param int $id
     * @return JsonResponse
     */

    public function show(int $id): JsonResponse
    {
        $teacher = $this->teacherRepository->find($id);

        $this->authorize('view', $teacher);

        return response()->json($teacher);
    }

    /**
     * Create Teacher.
     *
     * @param int $id
     * @return JsonResponse
     */

    public function store(CreateTeacherRequest $request): JsonResponse
    {
        $inputs = $request->all();
        $inputs['school_id'] = Auth::user()->school_id;

        return response()->json($this->teacherRepository->create($inputs));
    }
}

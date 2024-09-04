<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\JsonResponse;
use App\Repositories\TeacherRepository;
use App\Http\Filters\TeacherFilter;
use App\Http\Requests\CreateTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;

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

    public function all(TeacherFilter $filter): JsonResponse
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

        if (is_null($teacher)) return response()->json([], Response::HTTP_NOT_FOUND);

        $this->authorize('view', $teacher);

        return response()->json($teacher);
    }

    /**
     * Create Teacher.
     *
     * @param CreateTeacherRequest $request
     * 
     * @return JsonResponse
     */

    public function store(CreateTeacherRequest $request): JsonResponse
    {
        $inputs = $request->validated();
        $inputs['school_id'] = Auth::user()->school_id;

        return response()->json($this->teacherRepository->create($inputs), Response::HTTP_CREATED);
    }

    /**
     * Update Teacher.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @param int $id
     * @return JsonResponse
     */

    public function update(int $id, UpdateTeacherRequest $request): JsonResponse
    {
        $teacher = $this->teacherRepository->find($id);

        if (is_null($teacher)) return response()->json([], Response::HTTP_NOT_FOUND);

        $this->authorize('update', $teacher);

        return response()->json($this->teacherRepository->update($teacher, $request->validated()));
    }
}

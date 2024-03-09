<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\JsonResponse;
use App\Repositories\TeacherRepository;

class TeacherController extends BaseController
{
    private TeacherRepository $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * Retrieve paginated Teachers JSON Response.
     *
     * @return JsonResponse
     */

    public function getTeachers(): JsonResponse
    {
        return response()->json($this->teacherRepository->all());
    }

    /**
     * Retrieve Teacher JSON Response.
     *
     * @param int $id
     * @return JsonResponse
     */

    public function getTeacher(int $id): JsonResponse
    {
        return response()->json($this->teacherRepository->find($id));
    }
}

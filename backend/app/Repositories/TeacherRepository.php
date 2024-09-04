<?php

namespace App\Repositories;

use App\Models\Teacher;

use App\Http\Filters\TeacherFilter;
use Illuminate\Pagination\LengthAwarePaginator;

class TeacherRepository
{

    /**
     * Retrieve paginated Teachers.
     *
     * @param int $schoolId
     * @param TeacherFilter $filter
     * @return LengthAwarePaginator
     */

    public function all(int $schoolId, TeacherFilter $filter): LengthAwarePaginator
    {
        return Teacher::where('school_id', $schoolId)->filter($filter)->paginate();
    }

    /**
     * Retrieve Teacher.
     *
     * @param  int $id
     * @return Teacher|null
     */

    public function find(int $id): ?Teacher
    {
        return Teacher::find($id);
    }

    /**
     * Create Teacher.
     *
     * @param  array $data
     * @return Teacher
     */

    public function create(array $data): Teacher
    {
        return Teacher::create($data)->refresh();
    }

    /**
     * Update Teacher.
     *
     * @param Teacher $teacher
     * @param  array $data
     * @return Teacher
     */

    public function update(Teacher $teacher, array $data): Teacher
    {
        $teacher->update($data);
        return $teacher;
    }
}

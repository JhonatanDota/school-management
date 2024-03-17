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
     * @return Teacher
     */

    public function find(int $id): Teacher
    {
        return Teacher::findOrFail($id);
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
     * @param int $id
     * @param  array $data
     * @return Teacher
     */

    public function update(int $id, array $data): Teacher
    {
        $teacher = Teacher::find($id);
        $teacher->update($data);

        return $teacher;
    }
}

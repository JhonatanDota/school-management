<?php

namespace App\Repositories;

use App\Models\Teacher;

use Illuminate\Pagination\LengthAwarePaginator;

class TeacherRepository
{

    /**
     * Retrieve paginated Teachers.
     *
     * @return LengthAwarePaginator
     */

    public function all(): LengthAwarePaginator
    {
        return Teacher::paginate();
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
        return Teacher::create($data);
    }
}

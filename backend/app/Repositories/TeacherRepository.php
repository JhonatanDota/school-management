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
     * @return LengthAwarePaginator
     */

    public function find(int $id): Teacher
    {
        return Teacher::findOrFail($id);
    }
}

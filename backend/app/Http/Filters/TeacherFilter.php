<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class TeacherFilter extends Filter
{
    /**
     * Filter the products by the given string.
     *
     * @param  string|null  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function name(string $value = null): Builder
    {
        return $this->builder->where('name', 'like', "%{$value}%");
    }
}

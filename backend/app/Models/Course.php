<?php

namespace App\Models;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school_id',
        'name',
        'description',
    ];

    protected $baseRules = [
        'school_id' => 'required|exists:schools,id',
        'name' => 'required|max:255',
        'description' => 'string',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function courseLessons()
    {
        return $this->hasMany(\App\Models\CourseLesson::class)->orderBy('order');
    }
}

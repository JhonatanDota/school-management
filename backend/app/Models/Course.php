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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array string
     */
    protected $hidden = [
        'school_id',
    ];

    /**
     * Create Rules.
     *
     * @var array
     */
    public static $createRules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
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

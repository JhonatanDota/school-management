<?php

namespace App\Models;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseLesson extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'name',
        'order',
    ];

    // =========================================================================
    // Validations
    // =========================================================================

    private const MAX_NAME_LENGTH = 20;
    private const MIN_NAME_LENGTH = 3;

    public static $createRules = [
        'course_id' => ['required', 'exists:courses,id'],
        'name' => [
            'required',
            'string',
            'max:' . SELF::MAX_NAME_LENGTH,
            'min:' . SELF::MIN_NAME_LENGTH
        ],
        'order' => 'prohibited'
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function course()
    {
        return $this->belongsTo(\App\Models\Course::class);
    }
}

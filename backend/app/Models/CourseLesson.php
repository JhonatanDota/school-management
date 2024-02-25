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

    /**
     * Base Rules.
     *
     * @var array
     */
    private static $baseRules = [
        'course_id' => 'required|exists:courses,id',
        'name' => 'required|max:255',
        'order' => 'integer',
    ];

    /**
     * Rules to create object.
     *
     * @return array
     */
    public static function createRules(): array
    {
        return array_merge(self::$baseRules, []);
    }

    /**
     * Rules to update object.
     *
     * @return array
     */
    public static function updateRules(): array
    {
        return array_merge(self::$baseRules, [
            'order' => 'required|integer'
        ]);
    }

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

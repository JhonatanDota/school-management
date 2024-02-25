<?php

namespace App\Models;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Klass extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'teacher_id',
        'original_start_date',
    ];

    protected $baseRules = [
        'school_id' => 'required|exists:courses,id',
        'school_id' => 'required|exists:teachers,id',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function scheduledLessons()
    {
        return $this->hasMany(\App\Models\ScheduledLesson::class)->orderBy('datetime');
    }
}

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

    // =========================================================================
    // Validations
    // =========================================================================

    private const MAX_NAME_LENGTH = 30;
    private const MIN_NAME_LENGTH = 5;

    /**
     * Create Rules.
     *
     * @var array
     */
    public static $createRules = [
        'name' => [
            'required',
            'string',
            'max:' . SELF::MAX_NAME_LENGTH,
            'min:' . SELF::MIN_NAME_LENGTH
        ],
        'description' => ['nullable', 'string'],
    ];

    /**
     * Edit Rules.
     *
     * @var array
     */
    public static $updateRules = [
        'school_id' => 'prohibited',
        'name' => [
            'string',
            'max:' . SELF::MAX_NAME_LENGTH,
            'min:' . SELF::MIN_NAME_LENGTH
        ],
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

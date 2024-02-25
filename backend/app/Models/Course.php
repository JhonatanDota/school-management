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
     * Base Rules.
     *
     * @var array
     */
    private static $baseRules = [
        'school_id' => 'required|exists:schools,id',
        'name' => 'required|max:255',
        'description' => 'string',
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
        return array_merge(self::$baseRules, []);
    }
}

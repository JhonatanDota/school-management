<?php

namespace App\Models;

use App\Models\Model;

use App\Concerns\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school_id',
        'name',
        'email',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'school_id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'is_active' => 'boolean',
    ];

    /**
     * Create Rules.
     *
     * @var array
     */
    public static $createRules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:teachers,email,id_to_ignore',
        'is_active' => 'boolean'
    ];

    /**
     * Update Rules.
     *
     * @var array
     */

    public static $updateRules = [
        'school_id' => 'prohibited',
        'name' => 'string|max:255',
        'email' => 'email|unique:teachers,email,id_to_ignore',
        'is_active' => 'boolean'
    ];
}

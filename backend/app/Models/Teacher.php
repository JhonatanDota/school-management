<?php

namespace App\Models;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
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
        'email',
        'is_active',
    ];

    protected $baseRules = [
        'school_id' => 'required|exists:schools,id',
        'name' => 'required|max:255',
        'email' => 'required|email',
        'is_active' => 'boolean'
    ];
}

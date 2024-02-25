<?php

namespace App\Models;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Rules to create object.
     *
     * @var array
     */
    public static $createRules = [
        'name' => 'required|unique:schools|max:255'
    ];

    /**
     * Rules to update object.
     *
     * @var array
     */
    public static $updateRules = [
        'name' => 'required|unique:schools|max:255'
    ];
}

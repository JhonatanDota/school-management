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

    protected $baseRules = [
        'name' => 'required|unique:schools|max:255'
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function courses()
    {
        return $this->hasMany(\App\Models\Course::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function teachers()
    {
        return $this->hasMany(\App\Models\Teacher::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     **/
    public function klasses()
    {
        return $this->hasManyThrough(\App\Models\Klass::class, \App\Models\Course::class);
    }
}

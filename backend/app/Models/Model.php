<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel
{
    /**
     * Base Rules.
     *
     * @var array
     */
    protected static $baseRules = [];

    /**
     * Rules to create object.
     *
     * @return array
     */
    public static function createRules(): array
    {
        return array_merge(static::$baseRules, []);
    }

    /**
     * Rules to update object.
     *
     * @return array
     */
    public static function updateRules(): array
    {
        return array_merge(static::$baseRules, []);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    /**
     * Base Rules.
     *
     * @var array
     */
    protected $baseRules = [];

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

<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    /**
     * Retrieve Bearer authorization.
     *
     * @param string $token
     * @return array
     */

    protected function authorization(string $token): array
    {
        return [
            'Authorization' => "Bearer $token"
        ];
    }
}

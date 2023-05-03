<?php

namespace Tests;

use Exception;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class TestCase extends BaseTestCase {

    use CreatesApplication, DatabaseMigrations;

    use DatabaseTransactions;

    private Generator $faker;

    public function setUp()
    : void {

        parent::setUp();
        $this->faker = Factory::create();
    }

    public function __get($key) {

        if ($key === 'faker')
            return $this->faker;
        throw new Exception('Unknown Key Requested');
    }
}

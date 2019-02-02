<?php

namespace Tests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

abstract class DBTestCase extends TestCase
{
    use DatabaseMigrations;
}
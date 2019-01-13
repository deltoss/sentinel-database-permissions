<?php

namespace Deltoss\SentinelDatabasePermissions\Tests;

use Deltoss\SentinelDatabasePermissions\ExtendedSentinel;
use Sentinel;

class SentinelTest extends DatabaseTestCase
{
    public function testExtendedSentinelModel()
    {
        $sentinel = Sentinel::getFacadeRoot();
        $this->assertInstanceOf(ExtendedSentinel::class, $sentinel);
    }
}
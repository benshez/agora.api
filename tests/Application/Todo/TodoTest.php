<?php

namespace AgoraApi\Application\Todo;

use PHPUnit\Framework\TestCase;
use AgoraApi\Domain\Todo;

class TodoTest extends TestCase
{
    public function testShouldBeTrue()
    {
        $this->assertTrue(true);
    }

    public function testGenerateEtag()
    {
        $todo = new Todo;
        $this->assertEquals(32, strlen($todo->etag()));
    }
}

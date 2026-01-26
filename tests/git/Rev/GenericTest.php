<?php

namespace SebastianFeldmann\Git\Rev;

use PHPUnit\Framework\TestCase;

class GenericTest extends TestCase
{
    public function testGetter(): void
    {
        $ref = new Generic('head');
        $this->assertEquals('head', $ref->id());
    }
}

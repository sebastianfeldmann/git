<?php

namespace SebastianFeldmann\Git\Rev;

use PHPUnit\Framework\TestCase;

class PrePushTest extends TestCase
{
    public function testGetter(): void
    {
        $ref = new PrePush('refs/heads/main', '12345', 'main');

        $this->assertEquals('refs/heads/main', $ref->head());
        $this->assertEquals('12345', $ref->hash());
        $this->assertEquals('main', $ref->branch());
        $this->assertEquals('12345', $ref->id());
        $this->assertFalse($ref->isZeroRev());
    }
}

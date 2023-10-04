<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Diff;

use PHPUnit\Framework\TestCase;

class FilterUtilTest extends TestCase
{
    /**
     * Tests FilterUtil::sanitize
     */
    public function testSanitize(): void
    {
        $sanitized = FilterUtil::sanitize(['A', 'C', 'Z']);

        $this->assertFalse(in_array('Z', $sanitized));
        $this->assertTrue(in_array('A', $sanitized));
        $this->assertTrue(in_array('C', $sanitized));
    }

    /**
     * Tests FilterUtil::sanitize
     */
    public function testSanitizeEmpty(): void
    {
        $sanitized = FilterUtil::sanitize(['Q', 'L', 'Z']);

        $this->assertEmpty($sanitized);
    }
}

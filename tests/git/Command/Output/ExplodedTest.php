<?php

/**
 * This file is part of git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\Output;

use PHPUnit\Framework\TestCase;

/**
 * Class ExplodedTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 3.10.0
 */
class ExplodedTest extends TestCase
{
    /**
     * Tests Exploded::format
     */
    public function testFormat(): void
    {
        $out       = new Exploded('--', ['A', 'B', 'C']);
        $formatted = $out->format(['a--b--c', 'a--b--c']);

        $this->assertEquals('a', $formatted[0]['A']);
        $this->assertEquals('a', $formatted[1]['A']);
        $this->assertEquals('b', $formatted[0]['B']);
        $this->assertEquals('b', $formatted[1]['B']);
    }
}

<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\Describe;

use PHPUnit\Framework\TestCase;

class GetMostRecentTagTest extends TestCase
{
    /**
     * Tests GetMostRecentTag::getCommand
     */
    public function testGetMostRecentTag(): void
    {
        $cmd = new GetMostRecentTag();
        $this->assertEquals('git describe --tags --abbrev=0', $cmd->getCommand());
    }

    /**
     * Tests GetMostRecentTag::before
     */
    public function testGetMostRecentTagBeforeSomeOtherTag(): void
    {
        $cmd = new GetMostRecentTag();
        $cmd->before('1.0.0');
        $this->assertEquals('git describe --tags --abbrev=0 1.0.0^', $cmd->getCommand());
    }

    /**
     * Tests GetMostRecentTag::before
     */
    public function testGetMostRecentTagExcludeSomething(): void
    {
        $cmd = new GetMostRecentTag();
        $cmd->ignore('**-RC*');
        $this->assertEquals('git describe --tags --abbrev=0 --exclude=\'**-RC*\'', $cmd->getCommand());
    }
}

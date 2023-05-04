<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\Branch;

use PHPUnit\Framework\TestCase;

/**
 * Class ListRemoteTest
 *
 * @package SebastianFeldmann\Git
 * @author  David Eckhaus
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 3.7.0
 */
class ListRemoteTest extends TestCase
{
    public function testDefault(): void
    {
        $command = new ListRemote();

        $this->assertSame('git branch -r', $command->getCommand());
    }
}

<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\WriteTree;

use PHPUnit\Framework\TestCase;

/**
 * Class CreateTreeObjectTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 3.7.0
 */
class CreateTreeObjectTest extends TestCase
{
    public function testCommand()
    {
        $cmd = new CreateTreeObject();

        $this->assertSame('git write-tree', $cmd->getCommand());
    }
}

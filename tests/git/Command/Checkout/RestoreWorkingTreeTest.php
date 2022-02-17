<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\Checkout;

use PHPUnit\Framework\TestCase;

/**
 * Class RestoreWorkingTreeTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 3.7.0
 */
class RestoreWorkingTreeTest extends TestCase
{
    public function testDefault(): void
    {
        $command = new RestoreWorkingTree();

        $this->assertSame('git checkout --quiet -- \'.\'', $command->getCommand());
    }

    public function testSkipKooks(): void
    {
        $command = new RestoreWorkingTree();
        $command->skipHooks();

        $this->assertSame('git -c core.hooksPath=/dev/null checkout --quiet -- \'.\'', $command->getCommand());
    }

    public function testFiles(): void
    {
        $command = new RestoreWorkingTree();
        $command = $command->files([
            "foo/*",
            "foo bar.txt",
            "foo' 'bar.txt",
            "fooBar.txt",
        ]);

        $this->assertSame(
            "git checkout --quiet -- 'foo/*' 'foo bar.txt' 'foo'\'' '\''bar.txt' 'fooBar.txt'",
            $command->getCommand()
        );
    }
}

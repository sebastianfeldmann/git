<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\Rm;

use PHPUnit\Framework\TestCase;

/**
 * Class RemoveFilesTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 3.7.0
 */
class RemoveFilesTest extends TestCase
{
    public function testDryRun(): void
    {
        $remove = new RemoveFiles();
        $remove = $remove->dryRun();

        $this->assertSame('git rm --dry-run -- ', $remove->getCommand());
    }

    public function testCached(): void
    {
        $remove = new RemoveFiles();
        $remove = $remove->cached();

        $this->assertSame('git rm --cached -- ', $remove->getCommand());
    }

    public function testRecursive(): void
    {
        $remove = new RemoveFiles();
        $remove = $remove->recursive();

        $this->assertSame('git rm -r -- ', $remove->getCommand());
    }

    public function testFiles(): void
    {
        $remove = new RemoveFiles();
        $remove = $remove->files([
            "foo/*",
            "foo bar.txt",
            "foo' 'bar.txt",
            "fooBar.txt",
        ]);

        $this->assertSame(
            "git rm -- 'foo/*' 'foo bar.txt' 'foo'\'' '\''bar.txt' 'fooBar.txt'",
            $remove->getCommand()
        );
    }

    public function testCombinedMethods(): void
    {
        $remove = new RemoveFiles();
        $remove = $remove->dryRun()->recursive()->cached()->files([
            "foo/*",
            "foo bar.txt",
            "foo' 'bar.txt",
            "fooBar.txt",
        ]);

        $this->assertSame(
            "git rm --dry-run --cached -r -- 'foo/*' 'foo bar.txt' 'foo'\'' '\''bar.txt' 'fooBar.txt'",
            $remove->getCommand()
        );
    }
}

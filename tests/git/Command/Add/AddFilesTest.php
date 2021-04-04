<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\Add;

use PHPUnit\Framework\TestCase;

/**
 * Class AddFilesTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 3.7.0
 */
class AddFilesTest extends TestCase
{
    public function testDryRun(): void
    {
        $add = new AddFiles();
        $add = $add->dryRun();

        $this->assertSame('git add --dry-run -- ', $add->getCommand());
    }

    public function testUpdate(): void
    {
        $add = new AddFiles();
        $add = $add->update();

        $this->assertSame('git add --update -- ', $add->getCommand());
    }

    public function testAll(): void
    {
        $add = new AddFiles();
        $add = $add->all();

        $this->assertSame('git add --all -- ', $add->getCommand());
    }

    public function testNoAll(): void
    {
        $add = new AddFiles();
        $add = $add->noAll();

        $this->assertSame('git add --no-all -- ', $add->getCommand());
    }

    public function testIntentToAdd(): void
    {
        $add = new AddFiles();
        $add = $add->intentToAdd();

        $this->assertSame('git add --intent-to-add -- ', $add->getCommand());
    }

    public function testFiles(): void
    {
        $add = new AddFiles();
        $add = $add->files([
            "foo/*",
            "foo bar.txt",
            "foo' 'bar.txt",
            "føøBár.txt",
        ]);

        $this->assertSame(
            "git add -- 'foo/*' 'foo bar.txt' 'foo'\'' '\''bar.txt' 'føøBár.txt'",
            $add->getCommand()
        );
    }

    public function testCombinedMethods(): void
    {
        $add = new AddFiles();

        // It doesn't really make sense to use all these options at the same
        // time with `git add`, but we're testing that the command correctly
        // strings them together.
        $add = $add->dryRun()->update()->all()->noAll()->intentToAdd()->files([
            "foo/*",
            "foo bar.txt",
            "foo' 'bar.txt",
            "føøBár.txt",
        ]);

        $this->assertSame(
            'git add --dry-run --update --all --no-all --intent-to-add '
                . "-- 'foo/*' 'foo bar.txt' 'foo'\'' '\''bar.txt' 'føøBár.txt'",
            $add->getCommand()
        );
    }
}

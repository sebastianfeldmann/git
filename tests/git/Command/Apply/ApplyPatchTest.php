<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\Apply;

use PHPUnit\Framework\TestCase;

/**
 * Class ApplyPatchTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 3.7.0
 */
class ApplyPatchTest extends TestCase
{
    public function testDefaultCommand(): void
    {
        $command = new ApplyPatch();

        $this->assertSame(
            'git apply -p1 --whitespace=\'warn\' ',
            $command->getCommand()
        );
    }

    public function testPatchFiles(): void
    {
        $command = new ApplyPatch();
        $command->patches(['foo.patch', 'bar.patch']);

        $this->assertSame(
            'git apply -p1 --whitespace=\'warn\' \'foo.patch\' \'bar.patch\'',
            $command->getCommand()
        );
    }

    public function testWhitespace(): void
    {
        $command = (new ApplyPatch())->patches(['foo.patch'])->whitespace('nowarn');

        $this->assertSame(
            'git apply -p1 --whitespace=\'nowarn\' \'foo.patch\'',
            $command->getCommand()
        );
    }

    public function testPathComponents(): void
    {
        $command = (new ApplyPatch())->patches(['foo.patch'])->pathComponents(3);

        $this->assertSame(
            'git apply -p3 --whitespace=\'warn\' \'foo.patch\'',
            $command->getCommand()
        );
    }

    public function testIgnoreSpaceChange(): void
    {
        $command = (new ApplyPatch())->patches(['foo.patch'])->ignoreSpaceChange();

        $this->assertSame(
            'git apply -p1 --whitespace=\'warn\' --ignore-space-change \'foo.patch\'',
            $command->getCommand()
        );
    }
}

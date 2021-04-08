<?php

/**
 * This file is part of SebastianFeldmann\Cli.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command;

use SebastianFeldmann\Git\Command\Log\ChangedFiles;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 0.9.0
 */
class BaseTest extends TestCase
{
    /**
     * Tests Base::__toString
     */
    public function testToString()
    {
        $cmd = new ChangedFiles('/foo');
        $this->assertEquals(
            'git -C \'/foo\' log --format=\'\' --name-only --no-merges',
            (string) $cmd
        );
    }

    public function testToStringWithConfigParameters(): void
    {
        $cmd = new class extends Base {
            protected function getGitCommand(): string
            {
                return 'foo';
            }
        };

        $cmd->setConfigParameter('core.autocrlf', false)
            ->setConfigParameter('core.abbrev', 10)
            ->setConfigParameter('commit.gpgSign', true)
            ->setConfigParameter('diff.algorithm', 'patience');

        $this->assertSame(
            "git -c 'core.autocrlf=false' -c 'core.abbrev=10' "
                . "-c 'commit.gpgSign=true' -c 'diff.algorithm=patience' foo",
            (string) $cmd
        );

        $cmd->setConfigParameter('core.abbrev', null);

        $this->assertSame(
            "git -c 'core.autocrlf=false' "
            . "-c 'commit.gpgSign=true' -c 'diff.algorithm=patience' foo",
            (string) $cmd
        );
    }

    public function testToStringWithRootAndConfigParameters(): void
    {
        $cmd = new class ('/bar') extends Base {
            protected function getGitCommand(): string
            {
                return 'baz';
            }
        };

        $cmd->setConfigParameter('core.autocrlf', false);

        $this->assertSame(
            "git -C '/bar' -c 'core.autocrlf=false' baz",
            (string) $cmd
        );
    }
}

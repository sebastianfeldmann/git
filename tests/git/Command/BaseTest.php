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
}

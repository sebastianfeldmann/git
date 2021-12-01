<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace SebastianFeldmann\Git\Command\CloneCmd;

use PHPUnit\Framework\TestCase;
use SebastianFeldmann\Git\Command\CloneCmd\CloneCmd;
use SebastianFeldmann\Git\Url;

/**
 * Class CloneCmdTest
 *
 * @package SebastianFeldmann\Git
 * @author  Andreas Frömer
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 3.8.0
 */
final class CloneCmdTest extends TestCase
{
    /**
     * Tests GitClone::getCommand
     */
    public function testGitCloneCommand()
    {
        $clone = new CloneCmd(new Url('https://github.com/test/repo.git'));
        $this->assertEquals('git clone \'https://github.com/test/repo.git\'', $clone->getCommand());
    }

    /**
     * Tests GitClone::getCommand
     */
    public function testGitCloneCommandDir()
    {
        $clone = new CloneCmd(new Url('https://github.com/test/repo.git'));
        $clone = $clone->dir('fubar');
        $this->assertEquals('git clone \'https://github.com/test/repo.git\' \'fubar\'', $clone->getCommand());
    }

    /**
     * Tests GitClone::getCommand
     */
    public function testGitCloneCommandShallowClone()
    {
        $clone = new CloneCmd(new Url('https://github.com/test/repo.git'));
        $clone = $clone->depth(1);
        $this->assertEquals('git clone --depth=1 \'https://github.com/test/repo.git\'', $clone->getCommand());
    }
}

<?php

declare(strict_types=1);

namespace SebastianFeldmann\Git\Command\CloneCmd;

use PHPUnit\Framework\TestCase;
use SebastianFeldmann\Git\Command\CloneCmd\CloneCmd;

final class CloneCmdTest extends TestCase
{
    /**
     * Tests GitClone::getCommand
     */
    public function testGitCloneCommand()
    {
        $clone = new CloneCmd('https://github.com/test/repo.git');
        $this->assertEquals('git clone \'https://github.com/test/repo.git\' \'repo\'', $clone->getCommand());
    }

    public function testGitCloneCommandDir()
    {
        $clone = new CloneCmd('https://github.com/test/repo.git');
        $clone = $clone->dir('fubar');
        $this->assertEquals('git clone \'https://github.com/test/repo.git\' \'fubar\'', $clone->getCommand());
    }
}

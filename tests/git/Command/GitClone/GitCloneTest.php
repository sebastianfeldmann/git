<?php

declare(strict_types=1);

namespace SebastianFeldmann\Git\Command\GitClone;

use PHPUnit\Framework\TestCase;
use SebastianFeldmann\Git\Command\GitClone\GitClone;

final class GitCloneTest extends TestCase
{
    /**
     * Tests GitClone::getCommand
     */
    public function testGitCloneCommand()
    {
        $clone = new GitClone('https://github.com/test/repo.git');
        $this->assertEquals('git clone https://github.com/test/repo.git repo', $clone->getCommand());
    }

    public function testGitCloneCommandDir()
    {
        $clone = new GitClone('https://github.com/test/repo.git');
        $clone = $clone->dir('fubar');
        $this->assertEquals('git clone https://github.com/test/repo.git fubar', $clone->getCommand());
    }
}

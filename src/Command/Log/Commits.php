<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Command\Log;

/**
 * Class Commits
 *
 * @package SebastianFeldmann\Git
 */
class Commits extends Log
{
    /**
     * Return the command to execute.
     *
     * @return string
     * @throws \RuntimeException
     */
    protected function getGitCommand(): string
    {
        return 'log --pretty=format:' .  escapeshellarg($this->format)
               . $this->abbrev
               . $this->author
               . $this->merges
               . $this->since;
    }
}

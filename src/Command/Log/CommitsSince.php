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
 * Class CommitsSince
 *
 * @package SebastianFeldmann\Git
 */
class CommitsSince extends Log
{
    /**
     * Return the command to execute.
     *
     * @return string
     * @throws \RuntimeException
     */
    protected function getGitCommand(): string
    {
        return 'log --pretty=format:\'' .  $this->format . '\' --abbrev-commit'
               . $this->merges
               . $this->since;
    }
}

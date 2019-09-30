<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Operator;

use SebastianFeldmann\Git\Command\Describe\GetCurrentTag;
use SebastianFeldmann\Git\Command\RevParse\GetBranch;
use SebastianFeldmann\Git\Command\RevParse\GetCommitHash;
use SebastianFeldmann\Git\Command\Tag\GetTags;

/**
 * Class Info
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 1.0.8
 */
class Info extends Base
{
    /**
     * Returns the tag of the current commit
     *
     * @return string
     */
    public function getCurrentTag() : string
    {
        $cmd    = new GetCurrentTag($this->repo->getRoot());
        $result = $this->runner->run($cmd);

        return trim($result->getStdOut());
    }

    /**
     * Returns a list of tags for a given commit hash
     *
     * @param  string $hash
     * @return string[]
     */
    public function getTagsPointingTo(string $hash): array
    {
        $cmd = new GetTags($this->repo->getRoot());
        $cmd->pointingTo($hash);

        $result = $this->runner->run($cmd);

        return $result->getBufferedOutput();
    }

    /**
     * Returns the the hash of the current commit
     *
     * @return string
     */
    public function getCurrentCommitHash() : string
    {
        $cmd    = new GetCommitHash($this->repo->getRoot());
        $result = $this->runner->run($cmd);

        return trim($result->getStdOut());
    }

    /**
     * Returns the current branch name
     *
     * @return string
     */
    public function getCurrentBranch() : string
    {
        $cmd    = new GetBranch($this->repo->getRoot());
        $result = $this->runner->run($cmd);

        return trim($result->getStdOut());
    }
}

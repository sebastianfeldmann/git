<?php
/**
 * This file is part of CaptainHook.
 *
 * (c) Sebastian Feldmann <sf@sebastian.feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Operator;

use SebastianFeldmann\Git\Command\Log\ChangedFilesSince;
use SebastianFeldmann\Git\Command\Log\CommitsSince;

class Log extends Base
{
    /**
     * Get the list of files that changed since a given revision.
     *
     * @param  string $revision
     * @return array
     */
    public function getChangedFilesSince(string $revision) : array
    {
        $cmd    = ChangedFilesSince::create($this->repo->getRoot())->revision($revision);
        $result = $this->runner->run($cmd);

        return $result->getOutput();
    }

    /**
     * Get list of commits since given revision.
     *
     * @param  string $revision
     * @return array
     */
    public function getCommitsSince(string $revision) : array
    {
        $cmd       = CommitsSince::create($this->repo->getRoot())
                                 ->revision($revision)
                                 ->prettyFormat(CommitsSince\Jsonized::FORMAT);
        $formatter = new CommitsSince\Jsonized();
        $result    = $this->runner->run($cmd, $formatter);

        return $result->getFormattedOutput();
    }
}

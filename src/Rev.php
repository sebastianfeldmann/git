<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git;

/**
 * Ref interface
 *
 * Git references can be used in git commands to identify positions in the git history.
 * For example:
 *  - HEAD
 *  - 4FD60E21,
 *  - HEAD~3
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 3.16.0
 */
interface Rev
{
    /**
     * Returns the ref id that can be used in a git command
     *
     * This can be completely a hash, branch name, ref-log position...
     *
     * @return string
     */
    public function id(): string;
}

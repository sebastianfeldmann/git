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
     * Returns the tag tag of the current commit
     *
     * @return string
     */
    public function getCurrentTag() : string
    {
        $cmd    = new GetCurrentTag($this->repo->getRoot());
        $result = $this->runner->run($cmd);

        return trim($result->getStdOut());
    }
}

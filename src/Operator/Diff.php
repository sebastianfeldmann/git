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

use SebastianFeldmann\Git\Command\Diff\Compare;

/**
 * Diff operator
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 1.2.0
 */
class Diff extends Base
{
    /**
     * Returns a list of files and their changes.
     *
     * @param  string $from
     * @param  string $to
     * @return \SebastianFeldmann\Git\Diff\File[]
     */
    public function compare(string $from, string $to): array
    {
        $compare = (new Compare($this->repo->getRoot()))->revisions($from, $to)
                                                        ->ignoreWhitespacesAtEndOfLine();

        $result = $this->runner->run($compare, new Compare\FullDiffList());

        return $result->getFormattedOutput();
    }
}

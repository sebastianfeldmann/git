<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian.feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Output;

use SebastianFeldmann\Git\Command\Result;

/**
 * Interface OutputFormatter
 *
 * @package SebastianFeldmann\Git
 */
interface Formatter
{
    /**
     * Format the output.
     *
     * @param  \SebastianFeldmann\Git\Command\Result $result
     * @return void
     */
    public function format(Result $result);
}

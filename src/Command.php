<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian.feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git;

use SebastianFeldmann\Git\Command\Result;
use SebastianFeldmann\Git\Output\Formatter;

/**
 * Interface Command
 *
 * @package SebastianFeldmann\Git
 */
interface Command
{
    /**
     * Execute the command.
     *
     * @param  \SebastianFeldmann\Git\Output\Formatter $formatter
     * @return \SebastianFeldmann\Git\Command\Result
     */
    public function execute(Formatter $formatter) : Result;
}

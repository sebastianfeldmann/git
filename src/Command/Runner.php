<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Command;

use SebastianFeldmann\Git\Command;

/**
 * Interface Runner
 *
 * @package SebastianFeldmann\Git
 */
interface Runner
{
    /**
     * Execute a command.
     *
     * @param  \SebastianFeldmann\Git\Command                 $command
     * @param  \SebastianFeldmann\Git\Command\OutputFormatter $formatter
     * @return \SebastianFeldmann\Git\Command\Result
     */
    public function run(Command $command, OutputFormatter $formatter = null) : Result;
}

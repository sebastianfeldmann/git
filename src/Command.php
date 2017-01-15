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
 * Interface Command
 *
 * @package SebastianFeldmann\Git
 */
interface Command
{
    /**
     * Get the cli command.
     *
     * @return string
     */
    public function getCommand() : string;
}

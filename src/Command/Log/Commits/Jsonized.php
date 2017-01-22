<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Command\Log\Commits;

use SebastianFeldmann\Cli\Command\OutputFormatter;

/**
 * Class Jsonized
 *
 * @package SebastianFeldmann\Git
 */
class Jsonized implements OutputFormatter
{
    /**
     * Git log format to use.
     *
     * @var string
     */
    const FORMAT = '{"hash": "%h", "name": "%d", "description": "%s", "date": "%ci", "author": "%an"}';

    /**
     * Format the output.
     *
     * @param  array $output
     * @return iterable
     */
    public function format(array $output)
    {
        $formatted = [];
        foreach ($output as $row) {
            $formatted[] = json_decode($row);
        }
        return $formatted;
    }
}

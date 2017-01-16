<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Command\DiffIndex\GetStagedFiles;

use SebastianFeldmann\Cli\Command\OutputFormatter;

class FilterByStatus implements OutputFormatter
{
    /**
     * List of status to keep.
     *
     * @var array
     */
    private $status;

    /**
     * FilterByStatus constructor.
     *
     * @param array $status
     */
    public function __construct(array $status)
    {
        $this->status = $status;
    }

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
            $matches = [];
            if (preg_match('#[' . implode('|', $this->status) . ']\W+(\S+)#i', $row, $matches)) {
                $formatted[] = $matches[1];
            }
        }
        return $formatted;
    }
}

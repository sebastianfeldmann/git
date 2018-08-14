<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Diff;

/**
 * Class Change.
 *
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 1.2.0
 */
class Change
{
    /**
     * Optional file header.
     *
     * @var string
     */
    private $header;

    /**
     * Pre range ['from' => x, 'to' => y]
     *
     * @var array
     */
    private $pre;

    /**
     * Post range ['from' => x, 'to' => y]
     *
     * @var array
     */
    private $post;

    /**
     * List of changed lines.
     *
     * @var \SebastianFeldmann\Git\Diff\Line[]
     */
    private $lines = [];

    /**
     * Chan
     * ge constructor.
     *
     * @param string $ranges
     * @param string $header
     */
    public function __construct(string $ranges, string $header = '')
    {
        $this->header = $header;
        $this->splitRanges($ranges);
    }

    /**
     * Header getter.
     *
     * @return string
     */
    public function getHeader(): string
    {
        return $this->header;
    }

    /**
     * Pre range getter.
     *
     * @return array
     */
    public function getPre(): array
    {
        return $this->pre;
    }

    /**
     * Post range getter.
     *
     * @return array
     */
    public function getPost(): array
    {
        return $this->post;
    }

    /**
     * Return list of changed lines.
     *
     * @return \SebastianFeldmann\Git\Diff\Line[]
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    /**
     * Add a line to the change.
     *
     * @param \SebastianFeldmann\Git\Diff\Line $line
     */
    public function addLine(Line $line)
    {
        $this->lines[] = $line;
    }

    /**
     * Parse ranges and split them into pre and post range.
     *
     * @param string $ranges
     */
    private function splitRanges(string $ranges)
    {
        $matches = [];
        if (!preg_match('#^[\-|\+]{1}([0-9]+),([0-9]+) [\-\+]{1}([0-9]+),([0-9]+)$#', $ranges, $matches)) {
            throw new \RuntimeException('invalid ranges: ' . $ranges);
        }
        $this->pre  = ['from' => (int)$matches[1], 'to' => (int)$matches[2]];
        $this->post = ['from' => (int)$matches[3], 'to' => (int)$matches[4]];
    }
}

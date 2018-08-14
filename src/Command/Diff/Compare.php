<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Command\Diff;

use SebastianFeldmann\Git\Command\Base;

/**
 * Class Between
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 1.2.0
 */
class Compare extends Base
{
    /**
     * Compare A/B command snippet.
     *
     * @var string
     */
    protected $compare = '';

    /**
     * Ignore line endings.
     *
     * @var string
     */
    protected $ignoreEOL = '';

    /**
     * Show statistics only.
     *
     * @var string
     */
    protected $stats = '';

    /**
     * Ignore all whitespaces.
     *
     * @var string
     */
    private $ignoreWhitespaces = '';

    /**
     * Compare two given revisions.
     *
     * @param  string $from
     * @param  string $to
     * @return \SebastianFeldmann\Git\Command\Diff\Compare
     */
    public function revisions(string $from, string $to) : Compare
    {
        $this->compare = escapeshellarg($from) . ' ' . escapeshellarg($to);
        return $this;
    }

    /**
     * Set diff statistics option.
     *
     * @param  bool $bool
     * @return \SebastianFeldmann\Git\Command\Diff\Compare
     */
    public function statsOnly(bool $bool = true) : Compare
    {
        $this->stats = $this->useOption('--numstat', $bool);
        return $this;
    }

    /**
     * Set ignore spaces at end of line.
     *
     * @param  bool $bool
     * @return \SebastianFeldmann\Git\Command\Diff\Compare
     */
    public function ignoreWhitespacesAtEndOfLine(bool $bool = true) : Compare
    {
        $this->ignoreEOL = $this->useOption('--ignore-space-at-eol', $bool);
        return $this;
    }

    /**
     * Set ignore all whitespaces.
     *
     * @param  bool $bool
     * @return \SebastianFeldmann\Git\Command\Diff\Compare
     */
    public function ignoreWhitespaces(bool $bool = true) : Compare
    {
        $this->ignoreWhitespaces = $this->useOption('-w', $bool);
        return $this;
    }

    /**
     * Return the command to execute.
     *
     * @return string
     * @throws \RuntimeException
     */
    protected function getGitCommand(): string
    {
        return 'diff' . $this->ignoreWhitespaces . $this->ignoreEOL . $this->stats . ' ' . $this->compare;
    }
}

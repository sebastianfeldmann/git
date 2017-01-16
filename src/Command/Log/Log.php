<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Command\Log;

use SebastianFeldmann\Git\Command\Base;

/**
 * Class Log
 *
 * @package SebastianFeldmann\Git
 */
abstract class Log extends Base
{
    /**
     * Pretty log format.
     *
     * @var string
     */
    protected $format = '%h -%d %s (%ci) <%an>';

    /**
     * Include merge commits.
     *
     * @var string
     */
    protected $merges = ' --no-merges';

    /**
     * Use --abbrev-commit.
     *
     * @var bool
     */
    protected $abbrev = ' --abbrev-commit';

    /**
     * Can be revision or date query.
     *
     * @var string
     */
    protected $since;

    /**
     * Define the pretty log format.
     *
     * @param  string $format
     * @return \SebastianFeldmann\Git\Command\Log\Log
     */
    public function prettyFormat(string $format) : Log
    {
        $this->format = $format;
        return $this;
    }

    /**
     * Define merge commit behaviour.
     *
     * @param  bool $bool
     * @return \SebastianFeldmann\Git\Command\Log\Log
     */
    public function withMerges(bool $bool = true) : Log
    {
        $this->merges = ($bool ? '' : ' --no-merges');
        return $this;
    }

    /**
     * Define commit hash behaviour.
     *
     * @param  bool $bool
     * @return \SebastianFeldmann\Git\Command\Log\Log
     */
    public function abbrevCommit(bool $bool = true) : Log
    {
        $this->abbrev = ($bool ? ' --abbrev--commit' : '');
        return $this;
    }

    /**
     * Set start revision.
     *
     * @param  string $since
     * @return \SebastianFeldmann\Git\Command\Log\Log
     */
    public function revision(string $since) : Log
    {
        $this->since = ' ' . escapeshellarg($since) . '..';
        return $this;
    }

    /**
     * Set start date.
     *
     * @param  string $date
     * @return \SebastianFeldmann\Git\Command\Log\Log
     */
    public function date(string $date) : Log
    {
        $this->since = ' --since=' . escapeshellarg($date);
        return $this;
    }
}

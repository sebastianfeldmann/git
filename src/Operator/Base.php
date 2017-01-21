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

use SebastianFeldmann\Cli\Process\Runner;
use SebastianFeldmann\Git\Repository;

abstract class Base
{
    /**
     * @var \SebastianFeldmann\Cli\Command\Runner
     */
    protected $runner;

    /**
     * @var \SebastianFeldmann\Git\Repository
     */
    protected $repo;

    /**
     * Base constructor.
     *
     * @param \SebastianFeldmann\Cli\Process\Runner $runner
     * @param \SebastianFeldmann\Git\Repository     $repo
     */
    public function __construct(Runner $runner, Repository $repo)
    {
        $this->runner = $runner;
        $this->repo   = $repo;
    }
}

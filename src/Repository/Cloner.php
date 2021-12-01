<?php

declare(strict_types=1);

namespace SebastianFeldmann\Git\Repository;

use SebastianFeldmann\Cli\Command\Runner;
use SebastianFeldmann\Cli\Util;
use SebastianFeldmann\Git\Command\CloneCmd\CloneCmd;
use SebastianFeldmann\Git\Repository;
use SebastianFeldmann\Git\Url;

final class Cloner
{
    /**
     * @var false|string
     */
    private $root;

    /**
     * @var Runner
     */
    private $runner;
    /**
     * @var int
     */
    private $depth;

    /**
     * Cloner constructor
     *
     * @param string $root
     * @param Runner|null $runner
     */
    public function __construct(string $root = '', Runner $runner = null)
    {
        $this->root = empty($root) ? getcwd() : $root;
        $this->runner = $runner ?? new Runner\Simple();
    }

    public function depth(int $depth): Cloner
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * Use a shallow clone. Alias for depth(1)
     *
     * @return Cloner
     */
    public function shallowClone(): Cloner
    {
        return $this->depth(1);
    }

    /**
     * Clone a given repository $url.
     *
     * @param string $url Url of repository
     * @param string $dir The directory where the content should be cloned into.
     *                    If this is an absolute path this directory will be used.
     *                    If this is a relative path, and new folder will be created inside
     *                    the current working directory.
     */
    public function clone(string $url, string $dir = ''): Repository
    {
        $repositoryUrl = new Url($url);
        $cloneCommand = new CloneCmd($repositoryUrl);

        if (empty($dir)) {
            $dir = $this->root . '/' . $repositoryUrl->getRepoName();
        }

        if (!Util::isAbsolutePath($dir)) {
            $dir = $this->root . '/' . $dir;
        }

        $cloneCommand->dir($dir);

        if ($this->depth !== null) {
            $cloneCommand->depth($this->depth);
        }

        $this->runner->run($cloneCommand);

        return Repository::createVerified($dir, $this->runner);
    }
}

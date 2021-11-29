<?php

declare(strict_types=1);

namespace SebastianFeldmann\Git\Command\GitClone;

use SebastianFeldmann\Git\Command\Base;

final class GitClone extends Base
{
    /** @var string */
    private $url;
    /** @var string|null */
    private $dir;

    public function __construct(string $url)
    {
        $this->url = $url;
        parent::__construct();
    }

    public function dir(string $dir = null): GitClone
    {
        if (empty($dir)) {
            $lastSlashPosition = strrpos($this->url, '/');
            $dotGitPosition = strrpos($this->url, '.');
            $dir = substr(
                $this->url,
                $lastSlashPosition + 1,
                strlen($this->url) - $dotGitPosition
            );
        }

        $this->dir = $dir;

        return $this;
    }

    public function getDir(): string
    {
        return $this->dir;
    }

    protected function getGitCommand(): string
    {
        return 'clone ' . $this->url . ' ' . $this->dir;
    }
}

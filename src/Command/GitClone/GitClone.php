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
        $this->dir = $dir;

        return $this;
    }

    public function getDir(): string
    {
        if (empty($this->dir)) {
            $lastSlashPosition = strrpos($this->url, '/');
            $dotGitPosition = strrpos($this->url, '.');
            $this->dir = substr(
                $this->url,
                $lastSlashPosition + 1,
                strlen($this->url) - $dotGitPosition
            );
        }

        return $this->dir;
    }

    protected function getGitCommand(): string
    {
        return 'clone ' . escapeshellarg($this->url) . ' ' . escapeshellarg($this->getDir());
    }
}

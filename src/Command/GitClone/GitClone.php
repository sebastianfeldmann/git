<?php

declare(strict_types=1);

namespace SebastianFeldmann\Git\Command\GitClone;

use SebastianFeldmann\Git\Command\Base;

final class GitClone extends Base
{
    /** @var string */
    private $url;
    /** @var string */
    private $dir;

    public function __construct(string $url)
    {
        $this->url = $url;
        parent::__construct();
    }

    public function dir(string $dir = ''): GitClone
    {
        $this->dir = $dir;

        return $this;
    }

    public function getDir(): string
    {
        if (empty($this->dir)) {
            $lastSlashPosition = strrpos($this->url, '/');
            $this->dir = str_replace('.git', '', substr($this->url, $lastSlashPosition + 1));
        }

        return $this->dir;
    }

    protected function getGitCommand(): string
    {
        return 'clone ' . escapeshellarg($this->url) . ' ' . escapeshellarg($this->getDir());
    }
}

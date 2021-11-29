<?php

declare(strict_types=1);

namespace SebastianFeldmann\Git\Command\CloneCmd;

use SebastianFeldmann\Git\Command\Base;

final class CloneCmd extends Base
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

    public function dir(string $dir = ''): CloneCmd
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

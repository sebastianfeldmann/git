<?php

declare(strict_types=1);

namespace SebastianFeldmann\Git\Command\CloneCmd;

use SebastianFeldmann\Git\Command\Base;
use SebastianFeldmann\Git\Url;

final class CloneCmd extends Base
{
    /** @var Url */
    private $url;
    /** @var string */
    private $dir;

    public function __construct(Url $url)
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
            $this->dir = $this->url->getRepoName();
        }

        return $this->dir;
    }

    protected function getGitCommand(): string
    {
        return 'clone ' . escapeshellarg($this->url->getUrl()) . ' ' . escapeshellarg($this->getDir());
    }
}

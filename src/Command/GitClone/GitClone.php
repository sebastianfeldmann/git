<?php

declare(strict_types=1);

namespace SebastianFeldmann\Git\Command\GitClone;

use SebastianFeldmann\Git\Command\Base;

final class GitClone extends Base
{
    /** @var string */
    private $url;
    /** @var string */
    private $dir = '';

    public function __construct(string $url)
    {
        $this->url = $url;
        parent::__construct();
    }

    public function dir(string $dir): GitClone
    {
        $this->dir = $dir;

        return $this;
    }

    protected function getGitCommand(): string
    {
        $dir = $this->dir;

        if (empty($dir)) {
            $lastSlashPosition = strrpos($this->url, '/');
            $dir = substr(
                $this->url,
                $lastSlashPosition + 1,
                strlen($this->url) - $lastSlashPosition
            );
        }

        return 'clone ' . $this->url . ' ' . $dir;
    }
}

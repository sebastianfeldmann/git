<?php

declare(strict_types=1);

namespace SebastianFeldmann\Git\Command\CloneCmd;

use SebastianFeldmann\Git\Command\Base;
use SebastianFeldmann\Git\Url;

final class CloneCmd extends Base
{
    /**
     * @var Url
     */
    private $url;

    /**
     * @var string
     */
    private $dir = '';

    /**
     * @var string
     */
    private $depth = '';

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

    public function depth(int $depth): CloneCmd
    {
        $this->depth = $this->useOption('--depth ' . $depth, true);
        return $this;
    }

    protected function getGitCommand(): string
    {
        $command = 'clone'
            . $this->depth
            . ' '
            . escapeshellarg($this->url->getUrl());

        if (!empty($this->dir)) {
            $command .= ' '
                . escapeshellarg($this->dir);
        }

        return $command;
    }
}

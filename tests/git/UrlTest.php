<?php

declare(strict_types=1);

namespace SebastianFeldmann\Git;

use PHPUnit\Framework\TestCase;
use SebastianFeldmann\Git\Url;

final class UrlTest extends TestCase
{
    public function testHttpsUrl()
    {
        $url = new Url('https://github.com/icanhazstring/composer-unused.git');
        $this->assertEquals('https', $url->getScheme());
        $this->assertEquals('/icanhazstring/composer-unused.git', $url->getPath());
        $this->assertEquals('github.com', $url->getHost());
        $this->assertEquals('composer-unused', $url->getRepoName());
    }

    public function testSshUrl()
    {
        $url = new Url('git@github.com/icanhazstring/composer-unused.git');
        $this->assertEquals('/icanhazstring/composer-unused.git', $url->getPath());
        $this->assertEquals('github.com', $url->getHost());
        $this->assertEquals('composer-unused', $url->getRepoName());
    }

    public function testLocalUrl()
    {
        $url = new Url('/icanhazstring/composer-unused');
        $this->assertEquals('/icanhazstring/composer-unused', $url->getPath());
        $this->assertEquals('composer-unused', $url->getRepoName());
    }
}

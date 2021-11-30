<?php

declare(strict_types=1);

namespace SebastianFeldmann\Git;

use PHPUnit\Framework\TestCase;
use SebastianFeldmann\Git\Url;

final class UrlTest extends TestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testUrls($url, $scheme, $user, $host, $path, $repo)
    {
        $url = new Url($url);
        $this->assertEquals($scheme, $url->getScheme());
        $this->assertEquals($user, $url->getUser());
        $this->assertEquals($host, $url->getHost());
        $this->assertEquals($path, $url->getPath());
        $this->assertEquals($repo, $url->getRepoName());
    }

    public function urlProvider(): array
    {
        return [
            // url                                 scheme   user   host                   path              repo-name
            ['git@github.com:demo/repo.git',       'ssh',   'git', 'github.com',          '/demo/repo.git', 'repo'],
            ['ssh://git@github.com:demo/repo.git', 'ssh',   'git', 'github.com',          '/demo/repo.git', 'repo'],
            ['/some-dir/some-repo',                '', '',  '',    '/some-dir/some-repo', 'some-repo'],
            ['http://mygit.com/demo/repo.git',     'http',  '',    'mygit.com',           '/demo/repo.git', 'repo'],
            ['https://github.com/demo/repo.git',   'https', '',    'github.com',          '/demo/repo.git', 'repo'],
        ];
    }
}

<?php

declare(strict_types=1);

namespace SebastianFeldmann\Git;

final class Url
{
    /** @var string */
    private $url;
    /** @var string */
    private $host;
    /** @var string */
    private $path;
    /** @var string */
    private $scheme;
    /** @var string */
    private $repoName;

    public function __construct(string $url)
    {
        $this->url = $url;

        $parsed = $this->parseUrl($url);
        $this->host = $parsed['host'] ?? '';
        $this->path = $parsed['path'] ?? '';
        $this->scheme = $parsed['scheme'] ?? '';
        $this->repoName = $this->parseRepoName($this->path);
    }

    public static function isSshUrl(string $url): bool
    {
        return strpos($url, 'git@') !== false;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    private function parseRepoName(string $path): string
    {
        if (empty($path)) {
            return '';
        }

        $lastSlashPosition = strrpos($path, '/');
        return str_replace('.git', '', substr($path, $lastSlashPosition + 1));
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function getRepoName(): string
    {
        return $this->repoName;
    }

    private function parseUrl(string $url): array
    {
        // SSH urls can't be parsed by parse_url so we replace the user with a scheme.
        if (self::isSshUrl($url)) {
            $url = str_replace('git@', 'https://', $url);
        }

        return parse_url($url);
    }
}

<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git;

/**
 * Class DummyRepo
 *
 * Handle some file system operations to simulate a git repository.
 * DummyRepo creates a random directory with a '.git' sub directory and some dummy hook scripts.
 *
 * @package SebastianFeldmann\Git
 */
class DummyRepo
{
    /**
     * @var string
     */
    protected string $path = '';

    /**
     * @var string
     */
    protected string $gitDir = '';

    /**
     * Custom hook directory
     *
     * @var string
     */
    protected string $customHookDir = '';

    /**
     * DummyRepo constructor
     *
     * @param string $name
     * @param string $customHookDir
     */
    public function __construct(string $name = '', string $customHookDir = '')
    {
        $name                = empty($name) ? md5(mt_rand(0, 9999999)) : $name;
        $this->path          = realpath(sys_get_temp_dir()) . DIRECTORY_SEPARATOR . $name;
        $this->gitDir        = $this->path . DIRECTORY_SEPARATOR . '.git';
        $this->customHookDir = $customHookDir;
    }

    /**
     * Create the repository directory
     *
     * @return void
     */
    public function setup(): void
    {
        mkdir($this->gitDir . DIRECTORY_SEPARATOR . 'hooks', 0777, true);
        if (!empty($this->customHookDir)) {
            if (!is_dir($this->customHookDir)) {
                mkdir($this->path . DIRECTORY_SEPARATOR . $this->customHookDir, 0777, true);
            }
        }
    }

    /**
     * Create a hook script
     *
     * @param  string $name
     * @param  string $content
     * @return void
     */
    public function touchHook(string $name, string $content = '# dummy hook'): void
    {
        file_put_contents($this->gitDir . DIRECTORY_SEPARATOR . 'hooks' . DIRECTORY_SEPARATOR . $name, $content);
    }

    /**
     * Simulate a merge state
     *
     */
    public function merge(): void
    {
        file_put_contents($this->gitDir . DIRECTORY_SEPARATOR . 'MERGE_MSG', '# merge file');
    }

    /**
     * Path getter
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Git directory getter
     *
     * @return string
     */
    public function getGitDir(): string
    {
        return $this->getPath() . DIRECTORY_SEPARATOR . '.git';
    }

    /**
     * Hook directory getter
     *
     * @return string
     */
    public function getHookDir(): string
    {
        return $this->getGitDir() . DIRECTORY_SEPARATOR . 'hooks';
    }

    /**
     * Cleanup all dummy files
     *
     * @return void
     */
    public function cleanup(): void
    {
        system('rm -rf ' . $this->path);
    }
}

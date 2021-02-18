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
 * Class DummySubmoduleRepo
 *
 * If you're working within a submodule, there is no .git directory.
 * Instead their hooks are stored in the parents' repository .git/modules/<name>/hooks directory.
 *
 * Since submodules might be nested, the parent repository is not always the parent directory.
 *
 * @package SebastianFeldmann\Git
 */
class DummySubmoduleRepo extends DummyRepo
{
    /**
     * @var string
     */
    private $relativeGitDir;

    /**
     * @var int
     */
    private $level;

    public function __construct(string $name = '', int $level = 1)
    {
        $this->level = $level;

        $parents = '';
        for ($i = 0; $i < $level; $i++) {
            if (!empty($parents)) {
                $parents .= DIRECTORY_SEPARATOR;
            }
            $parents .= md5(mt_rand(0, 9999));
        }

        $name       = empty($name) ? md5(mt_rand(0, 9999)) : $name;
        $this->path = realpath(sys_get_temp_dir()) . DIRECTORY_SEPARATOR . $parents . DIRECTORY_SEPARATOR . $name;

        $this->relativeGitDir = str_repeat('..' . DIRECTORY_SEPARATOR, $level)
            . '.git' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $name;
        $this->gitDir         = $this->path . DIRECTORY_SEPARATOR . $this->relativeGitDir;
    }

    public function setup(): void
    {
        parent::setup();

        mkdir($this->path, 0777, true);
        file_put_contents($this->path . DIRECTORY_SEPARATOR . '.git', 'gitdir: ' . $this->relativeGitDir);
    }

    /**
     * Level getter
     *
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * Cleanup all dummy files
     *
     * @return void
     */
    public function cleanup(): void
    {
        $parent = dirname($this->path, $this->level);
        system('rm -rf ' . escapeshellarg($parent));
    }
}

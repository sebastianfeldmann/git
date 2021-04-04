<?php

/**
 * This file is part of CaptainHook.
 *
 * (c) Sebastian Feldmann <sf@sebastian.feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Operator;

use RuntimeException;
use SebastianFeldmann\Git\Command\Add\AddFiles;
use SebastianFeldmann\Git\Command\DiffIndex\GetStagedFiles;
use SebastianFeldmann\Git\Command\DiffIndex\GetStagedFiles\FilterByStatus;
use SebastianFeldmann\Git\Command\RevParse\GetCommitHash;

/**
 * Index CommitMessage
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 0.9.0
 */
class Index extends Base
{
    /**
     * List of changed files.
     *
     * @var array
     */
    private $files;

    /**
     * Changed files by file type
     *
     * @var array[]
     */
    private $types = [];

    /**
     * Files sorted by suffix yet
     *
     * @var bool
     */
    private $typesResolved = false;

    /**
     * Get the list of files that changed.
     *
     * @return array
     */
    public function getStagedFiles(): array
    {
        if (null === $this->files) {
            $this->resolveFiles();
        }
        return $this->files;
    }

    /**
     * Where there files changed of a given type.
     *
     * @param  string $suffix
     * @return bool
     */
    public function hasStagedFilesOfType($suffix): bool
    {
        return count($this->getStagedFilesOfType($suffix)) > 0;
    }

    /**
     * Return list of changed files of a given type.
     *
     * @param  string $suffix
     * @return array
     */
    public function getStagedFilesOfType($suffix): array
    {
        if (!$this->typesResolved) {
            $this->resolveFileTypes();
        }
        return isset($this->types[$suffix]) ? $this->types[$suffix] : [];
    }

    /**
     * Update the index using the current content found in the working tree.
     *
     * @param array $files
     *
     * @return bool
     */
    public function addFilesToIndex(array $files): bool
    {
        $cmd = (new AddFiles($this->repo->getRoot()))->files($files);

        $result = $this->runner->run($cmd);

        return $result->isSuccessful();
    }

    /**
     * Update the index just where it already has an entry matching <pathspec>.
     *
     * This removes as well as modifies index entries to match the working tree,
     * but adds no new files.
     *
     * @param array $files
     *
     * @return bool
     */
    public function updateIndex(array $files): bool
    {
        $cmd = (new AddFiles($this->repo->getRoot()))->files($files)->update();

        $result = $this->runner->run($cmd);

        return $result->isSuccessful();
    }

    /**
     * Update the index not only where the working tree has a file matching
     * <pathspec> but also where the index already has an entry.
     *
     * This adds, modifies, and removes index entries to match the working tree.
     *
     * If `$ignoreRemoval` is `true`, files removed in the working tree are
     * ignored and not removed from the index.
     *
     * @param array $files
     * @param bool $ignoreRemoval Ignore files that have been removed
     *     from the working tree.
     *
     * @return bool
     */
    public function updateIndexToMatchWorkingTree(array $files, bool $ignoreRemoval = false): bool
    {
        $all = !$ignoreRemoval;

        $cmd = (new AddFiles($this->repo->getRoot()))
            ->files($files)
            ->all($all)
            ->noAll($ignoreRemoval);

        $result = $this->runner->run($cmd);

        return $result->isSuccessful();
    }

    /**
     * Record only the fact that the path will be added later.
     *
     * An entry for the path is placed in the index with no content.
     *
     * @param array $files
     *
     * @return bool
     */
    public function recordIntentToAddFiles(array $files): bool
    {
        $cmd = (new AddFiles($this->repo->getRoot()))->files($files)->intentToAdd();

        $result = $this->runner->run($cmd);

        return $result->isSuccessful();
    }

    /**
     * Resolve the list of files that changed.
     */
    private function resolveFiles()
    {
        $this->files = [];

        if ($this->isHeadValid()) {
            $cmd         = new GetStagedFiles($this->repo->getRoot());
            $formatter   = new FilterByStatus(['A', 'M']);
            $result      = $this->runner->run($cmd, $formatter);
            $this->files = $result->getFormattedOutput();
        }
    }

    /**
     * Sort files by file suffix.
     */
    private function resolveFileTypes()
    {
        foreach ($this->getStagedFiles() as $file) {
            $ext                 = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $this->types[$ext][] = $file;
        }
        $this->typesResolved = true;
    }

    /**
     * Check head validity.
     *
     * @return bool
     */
    private function isHeadValid(): bool
    {
        try {
            $cmd    = new GetCommitHash($this->repo->getRoot());
            $result = $this->runner->run($cmd);
            return $result->isSuccessful();
        } catch (RuntimeException $e) {
            return false;
        }
    }
}

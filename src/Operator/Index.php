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
     * Get the lst of files that changed.
     *
     * @return array
     */
    public function getStagedFiles() : array
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
    public function hasStagedFilesOfType($suffix) : bool
    {
        return count($this->getStagedFilesOfType($suffix)) > 0;
    }

    /**
     * Return list of changed files of a given type.
     *
     * @param  string $suffix
     * @return array
     */
    public function getStagedFilesOfType($suffix) : array
    {
        if (!$this->typesResolved) {
            $this->resolveFileTypes();
        }
        return isset($this->types[$suffix]) ? $this->types[$suffix] : [];
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
    private function isHeadValid() : bool
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

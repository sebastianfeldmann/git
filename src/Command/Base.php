<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Command;

use SebastianFeldmann\Cli\Command;

/**
 * Class Base
 *
 * @package SebastianFeldmann\Git
 */
abstract class Base implements Command
{
    /**
     * Repository root directory
     *
     * @var string
     */
    protected $repositoryRoot;

    /**
     * Base constructor.
     *
     * @param string $root
     */
    public function __construct(string $root = '')
    {
        $this->repositoryRoot = $root;
    }

    /**
     * Get from to git diff snippet.
     *
     * @param  string $from
     * @param  string $to
     * @return string
     */
    protected function getFromToSnippet(string $from, string $to) : string
    {
        return $from . (empty($to) ? '' : ' ' . $to);
    }

    /**
     * Return cli command to execute.
     *
     * @return string
     */
    public function getCommand() : string
    {
        $command = 'git'
                 . $this->getRootOption()
                 . ' '
                 . $this->getGitCommand();
        /*
        if (DIRECTORY_SEPARATOR == '/') {
            $command = 'LC_ALL=en_US.UTF-8 ' . $command;
        }
        */
        return $command;
    }

    /**
     * Do we need the -C option.
     *
     * @return string
     */
    protected function getRootOption() : string
    {
        $option = '';
        // if root is set
        if (!empty($this->repositoryRoot)) {
            // and it's not the current working directory
            if (getcwd() !== $this->repositoryRoot) {
                $option =  ' -C ' . escapeshellarg($this->repositoryRoot);
            }

        }
        return $option;
    }

    /**
     * Auto cast method.
     *
     * @return string
     */
    public function __toString() : string
    {
        return $this->getCommand();
    }

    /**
     * Return the command to execute.
     *
     * @return string
     * @throws \RuntimeException
     */
    protected abstract function getGitCommand() : string;
}

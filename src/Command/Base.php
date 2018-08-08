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
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 0.9.0
 */
abstract class Base implements Command
{
    /**
     * Repository root directory.
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
        return $command;
    }

    /**
     * Return list of acceptable exit codes.
     *
     * @return array
     */
    public function getAcceptableExitCodes() : array
    {
        return [0];
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
     * Should a option be used or not.
     *
     * @param  string $option
     * @param  bool   $switch
     * @return string
     */
    protected function useOption(string $option, bool $switch) : string
    {
        return ($switch ? ' ' . $option : '');
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

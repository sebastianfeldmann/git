<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian.feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git;

use SebastianFeldmann\Git\Command\DefaultFactory;
use SebastianFeldmann\Git\Command\Factory;

/**
 * Class Repository
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 0.9.0
 */
class Repository
{
    /**
     * Path to git repository root.
     *
     * @var string
     */
    private $root;

    /**
     * Path to .git directory
     *
     * @var string
     */
    private $dotGitDir;

    /**
     * Commit message.
     *
     * @var \SebastianFeldmann\Git\CommitMessage
     */
    private $commitMsg;

    /**
     * @var \SebastianFeldmann\Git\Command\Factory
     */
    private $cmdFactory;

    /**
     * Repository constructor.
     *
     * @param string                                 $root
     * @param \SebastianFeldmann\Git\Command\Factory $factory
     */
    public function __construct(string $root = '', Factory $factory = null)
    {
        $path = empty($root) ? getcwd() : realpath($root);
        // check for existing .git dir
        if (!is_dir($path . DIRECTORY_SEPARATOR . '.git')) {
            throw new \RuntimeException(sprintf('Invalid git repository: %s', $root));
        }
        $this->root       = $path;
        $this->dotGitDir  = $this->root . DIRECTORY_SEPARATOR . '.git';
        $this->cmdFactory = null == $factory ? new DefaultFactory($this->root) : $factory;
    }

    /**
     * Root path getter.
     *
     * @return string
     */
    public function getRoot() : string
    {
        return $this->root;
    }

    /**
     * Returns the path to the hooks directory.
     *
     * @return string
     */
    public function getHooksDir() : string
    {
        return $this->dotGitDir . DIRECTORY_SEPARATOR . 'hooks';
    }

    /**
     * Check for a hook file.
     *
     * @param  string $hook
     * @return bool
     */
    public function hookExists($hook) : bool
    {
        return file_exists($this->getHooksDir() . DIRECTORY_SEPARATOR . $hook);
    }

    /**
     * CommitMessage setter.
     *
     * @param \SebastianFeldmann\Git\CommitMessage $commitMsg
     */
    public function setCommitMsg(CommitMessage $commitMsg)
    {
        $this->commitMsg = $commitMsg;
    }

    /**
     * CommitMessage getter.
     *
     * @return \SebastianFeldmann\Git\CommitMessage
     */
    public function getCommitMsg() : CommitMessage
    {
        if (null === $this->commitMsg) {
            throw new \RuntimeException('No commit message available');
        }
        return $this->commitMsg;
    }

    public function checkout(string $revision)
    {
    }

    public function log(string $from, string $to)
    {
    }

    /**
     * Create and return git commands.
     *
     * @param  string $name
     * @return mixed
     */
    private function getCommand(string $name)
    {
        return $this->cmdFactory->getCommand($name);
    }
}

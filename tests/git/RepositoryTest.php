<?php
/**
 * This file is part of SebastianFeldmann\git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git;

/**
 * Class RepositoryTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 0.9.0
 */
class RepositoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \SebastianFeldmann\Git\DummyRepo
     */
    private $repo;

    /**
     * Setup dummy repo.
     */
    public function setUp()
    {
        $this->repo = new DummyRepo();
        $this->repo->setup();
    }

    /**
     * Cleanup dummy repo.
     */
    public function tearDown()
    {
        $this->repo->cleanup();
    }

    /**
     * Tests Repository::__construct
     *
     * @expectedException \Exception
     */
    public function testInvalidRepository()
    {
        $repository = new Repository('invalidGitRepo');
        $this->assertFalse(is_a($repository, '\\SebastianFeldmann\\Git\\Repository'));
    }

    /**
     * Tests Repository::getCommitMessage
     */
    public function testGetCommitMessage()
    {
        $message = new CommitMessage('Foo bar baz');
        $repo    = new Repository();
        $repo->setCommitMsg($message);

        $this->assertEquals($message, $repo->getCommitMsg());
    }

    /**
     * Tests Repository::getHooks
     */
    public function testGetHooksDir()
    {
        $repository = new Repository($this->repo->getPath());
        $this->assertEquals($this->repo->getPath() . '/.git/hooks', $repository->getHooksDir());
        $this->assertEquals($this->repo->getPath(), $repository->getRoot());
    }

    /**
     * Tests Repository::hookExists
     */
    public function testHookExists()
    {
        $this->repo->touchHook('pre-commit');

        $repository = new Repository($this->repo->getPath());

        $this->assertTrue($repository->hookExists('pre-commit'));
        $this->assertFalse($repository->hookExists('pre-push'));
    }

    /**
     * Tests Repository::getCommitMsg
     *
     * @expectedException \Exception
     */
    public function testGetCommitMessageFail()
    {
        $repository = new Repository($this->repo->getPath());
        $repository->getCommitMsg();
    }

    /**
     * Tests Repository::isMerging
     */
    public function testIsMergingNegative()
    {
        $repository = new Repository($this->repo->getPath());
        $this->assertFalse($repository->isMerging());
    }

    /**
     * Tests Repository::isMerging
     */
    public function testIsMergingPositive()
    {
        $this->repo->merge();
        $repository = new Repository($this->repo->getPath());
        $this->assertTrue($repository->isMerging());
    }

    /**
     * Tests Repository::getIndexOperator
     */
    public function testGetIndexOperator()
    {
        $repository = new Repository($this->repo->getPath());
        $operator   = $repository->getIndexOperator();

        $this->assertTrue(is_a($operator, '\\SebastianFeldmann\\Git\\Operator\\Index'));
    }

    /**
     * Tests Repository::getInfoOperator
     */
    public function testGetInfoOperator()
    {
        $repository = new Repository($this->repo->getPath());
        $operator   = $repository->getInfoOperator();

        $this->assertTrue(is_a($operator, '\\SebastianFeldmann\\Git\\Operator\\Info'));
    }

    /**
     * Tests Repository::getLogOperator
     */
    public function testGetLopOperator()
    {
        $repository = new Repository($this->repo->getPath());
        $operator   = $repository->getLogOperator();

        $this->assertTrue(is_a($operator, '\\SebastianFeldmann\\Git\\Operator\\Log'));
    }

    /**
     * Tests Repository::getConfigOperator
     */
    public function testGetConfigOperator()
    {
        $repository = new Repository($this->repo->getPath());
        $operator   = $repository->getConfigOperator();

        $this->assertTrue(is_a($operator, '\\SebastianFeldmann\\Git\\Operator\\Config'));
    }
}

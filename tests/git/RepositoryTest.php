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

use SebastianFeldmann\Git\Operator\Diff;
use SebastianFeldmann\Git\Operator\Index;
use SebastianFeldmann\Git\Operator\Info;
use SebastianFeldmann\Git\Operator\Log;
use SebastianFeldmann\Git\Operator\Config;
use PHPUnit\Framework\TestCase;

/**
 * Class RepositoryTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 0.9.0
 */
class RepositoryTest extends TestCase
{
    /**
     * @var \SebastianFeldmann\Git\DummyRepo
     */
    private $repo;

    /**
     * Setup dummy repo.
     */
    public function setUp(): void
    {
        $this->repo = new DummyRepo();
        $this->repo->setup();
    }

    /**
     * Cleanup dummy repo.
     */
    public function tearDown(): void
    {
        $this->repo->cleanup();
    }

    /**
     * Tests Repository::__construct
     */
    public function testInvalidRepository()
    {
        $this->expectException(\Exception::class);

        $repository = new Repository('invalidGitRepo');

        $this->assertNotInstanceOf(Repository::class, $repository);
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
     */
    public function testGetCommitMessageFail()
    {
        $this->expectException(\Exception::class);
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

        $this->assertInstanceOf(Index::class, $operator);
    }

    /**
     * Tests Repository::getInfoOperator
     */
    public function testGetInfoOperator()
    {
        $repository = new Repository($this->repo->getPath());
        $operator   = $repository->getInfoOperator();

        $this->assertInstanceOf(Info::class, $operator);
    }

    /**
     * Tests Repository::getLogOperator
     */
    public function testGetLopOperator()
    {
        $repository = new Repository($this->repo->getPath());
        $operator   = $repository->getLogOperator();

        $this->assertInstanceOf(Log::class, $operator);
    }

    /**
     * Tests Repository::getConfigOperator
     */
    public function testGetConfigOperator()
    {
        $repository = new Repository($this->repo->getPath());
        $operator   = $repository->getConfigOperator();

        $this->assertInstanceOf(Config::class, $operator);
    }

    /**
     * Tests Repository::getDiffOperator
     */
    public function testGetDiffOperator()
    {
        $repository = new Repository($this->repo->getPath());
        $operator   = $repository->getDiffOperator();

        $this->assertInstanceOf(Diff::class, $operator);
    }
}

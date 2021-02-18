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

use PHPUnit\Framework\TestCase;
use SebastianFeldmann\Git\Operator\Config;
use SebastianFeldmann\Git\Operator\Diff;
use SebastianFeldmann\Git\Operator\Index;
use SebastianFeldmann\Git\Operator\Info;
use SebastianFeldmann\Git\Operator\Log;

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
     * Data provider
     *
     * @return array
     */
    public function repoProvider(): array
    {
        $repo = new DummyRepo();
        $repo->setup();

        $repoWithSubmodule = new DummySubmoduleRepo();
        $repoWithSubmodule->setup();

        $nestedRepoWithSubmodule = new DummySubmoduleRepo('', 2);
        $nestedRepoWithSubmodule->setup();

        return [
            [$repo],
            [$repoWithSubmodule],
            [$nestedRepoWithSubmodule],
        ];
    }

    /**
     * Cleanup dummy repo.
     */
    protected function tearDown(): void
    {
        // use reflection to see if repository was in use
        $reflectionData = new \ReflectionProperty('\PHPUnit\Framework\TestCase', 'data');
        $reflectionData->setAccessible(true);
        $data = $reflectionData->getValue($this);
        if (!empty($data) && $data[0] instanceof DummyRepo) {
            $data[0]->cleanup();
        }
    }

    /**
     * Tests Repository::createVerified
     */
    public function testInvalidRepository()
    {
        $this->expectException(\Exception::class);

        $repository = Repository::createVerified('invalidGitRepo');

        $this->assertNotInstanceOf(Repository::class, $repository);
    }

    /**
     * Tests Repository::getCommitMessage
     *
     * @dataProvider repoProvider
     * @param DummyRepo $repo
     */
    public function testGetCommitMessage(DummyRepo $repo)
    {
        $message = new CommitMessage('Foo bar baz');
        $repo    = Repository::createVerified($repo->getPath());
        $repo->setCommitMsg($message);

        $this->assertEquals($message, $repo->getCommitMsg());
    }

    /**
     * Tests Repository::getHooks
     *
     * @dataProvider repoProvider
     * @param DummyRepo $repo
     */
    public function testGetHooksDir(DummyRepo $repo)
    {
        $repository = new Repository($repo->getPath());

        if ($repo instanceof DummySubmoduleRepo) {
            $name = basename($repo->getPath());
            $expectedHooksDir = dirname($repo->getPath(), $repo->getLevel()) . '/.git/modules/' . $name . '/hooks';
        } else {
            $expectedHooksDir = $repo->getPath() . '/.git/hooks';
        }
        $this->assertEquals($expectedHooksDir, realpath($repository->getHooksDir()));
        $this->assertEquals($repo->getPath(), $repository->getRoot());
    }

    /**
     * Tests Repository::hookExists
     *
     * @dataProvider repoProvider
     * @param DummyRepo $repo
     */
    public function testHookExists(DummyRepo $repo)
    {
        $repo->touchHook('pre-commit');

        $repository = new Repository($repo->getPath());

        $this->assertTrue($repository->hookExists('pre-commit'));
        $this->assertFalse($repository->hookExists('pre-push'));
    }

    /**
     * Tests Repository::getCommitMsg
     *
     * @dataProvider repoProvider
     * @param DummyRepo $repo
     */
    public function testGetCommitMessageFail(DummyRepo $repo)
    {
        $this->expectException(\Exception::class);
        $repository = new Repository($repo->getPath());
        $repository->getCommitMsg();
    }

    /**
     * Tests Repository::isMerging
     *
     * @dataProvider repoProvider
     * @param DummyRepo $repo
     */
    public function testIsMergingNegative(DummyRepo $repo)
    {
        $repository = new Repository($repo->getPath());

        $this->assertFalse($repository->isMerging());
    }

    /**
     * Tests Repository::isMerging
     *
     * @dataProvider repoProvider
     * @param DummyRepo $repo
     */
    public function testIsMergingPositive(DummyRepo $repo)
    {
        $repo->merge();
        $repository = new Repository($repo->getPath());

        $this->assertTrue($repository->isMerging());
    }

    /**
     * Tests Repository::getIndexOperator
     *
     * @dataProvider repoProvider
     * @param DummyRepo $repo
     */
    public function testGetIndexOperator(DummyRepo $repo)
    {
        $repository = new Repository($repo->getPath());
        $operator   = $repository->getIndexOperator();

        $this->assertInstanceOf(Index::class, $operator);
    }

    /**
     * Tests Repository::getInfoOperator
     *
     * @dataProvider repoProvider
     * @param DummyRepo $repo
     */
    public function testGetInfoOperator(DummyRepo $repo)
    {
        $repository = new Repository($repo->getPath());
        $operator   = $repository->getInfoOperator();

        $this->assertInstanceOf(Info::class, $operator);
    }

    /**
     * Tests Repository::getLogOperator
     *
     * @dataProvider repoProvider
     * @param DummyRepo $repo
     */
    public function testGetLopOperator(DummyRepo $repo)
    {
        $repository = new Repository($repo->getPath());
        $operator   = $repository->getLogOperator();

        $this->assertInstanceOf(Log::class, $operator);
    }

    /**
     * Tests Repository::getConfigOperator
     *
     * @dataProvider repoProvider
     * @param DummyRepo $repo
     */
    public function testGetConfigOperator(DummyRepo $repo)
    {
        $repository = new Repository($repo->getPath());
        $operator   = $repository->getConfigOperator();

        $this->assertInstanceOf(Config::class, $operator);
    }

    /**
     * Tests Repository::getDiffOperator
     *
     * @dataProvider repoProvider
     * @param DummyRepo $repo
     */
    public function testGetDiffOperator(DummyRepo $repo)
    {
        $repository = new Repository($repo->getPath());
        $operator   = $repository->getDiffOperator();

        $this->assertInstanceOf(Diff::class, $operator);
    }
}

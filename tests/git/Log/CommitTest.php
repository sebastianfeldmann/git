<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Log;

use PHPUnit\Framework\TestCase;

/**
 * Class CommitTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 1.2.0
 */
class CommitTest extends TestCase
{
    /**
     * Tests Commit::__construct
     */
    public function testCommitOk()
    {
        $commit = new Commit(
            '1de52f8',
            ['HEAD -> master'],
            'Some stupid message',
            new \DateTimeImmutable('2018-08-08 14:04:23'),
            'John Doe'
        );

        $this->assertEquals('1de52f8', $commit->getHash());
        $this->assertEquals(['HEAD -> master'], $commit->getNames());
        $this->assertEquals('Some stupid message', $commit->getDescription());
        $this->assertEquals('John Doe', $commit->getAuthor());
        $this->assertEquals('20180808', $commit->getDate()->format('Ymd'));
    }
}

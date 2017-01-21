<?php
/**
 * This file is part of SebastianFeldmann\Cli.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Command\Log\CommitsSince;

/**
 * Class JsonizedTest
 *
 * @package SebastianFeldmann\Git
 */
class JsonizedTest extends \PHPUnit_Framework_TestCase
{
    public function testFormat()
    {
        $formatter = new Jsonized();
        $result    = $formatter->format([
           '{"hash": "a9d9ac5", "name": " (HEAD -> master, origin/master, origin/HEAD)", ' .
           '"description": "Fix case in path", "date": "2017-01-16 02:16:13 +0100", "author": "Sebastian Feldmann"}',
        ]);

        $this->assertEquals(1, count($result));
        $this->assertTrue(is_a($result[0], '\\stdClass'));
        $this->assertEquals('a9d9ac5', $result[0]->hash);
        $this->assertEquals('Sebastian Feldmann', $result[0]->author);
    }
}

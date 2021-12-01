<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Repository;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use SebastianFeldmann\Cli\Command\Runner;

/**
 * Class ClonerTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 3.8.0
 */
class ClonerTest extends TestCase
{
    public function testClone(): void
    {
        $fakeRepo = vfsStream::setup('root', null, $this->setupRepo());
        $path     = $fakeRepo->url();
        $runner   = $this->getMockBuilder(Runner::class)
                       ->disableOriginalConstructor()
                       ->getMock();
        $runner->expects($this->atLeast(1))->method('run');

        $cloner = new Cloner($path, $runner);
        $cloner->depth(1);

        $repository = $cloner->clone('/fake-repo/foo');
    }

    /**
     * Setup fake filesystem structure
     *
     * @return array[]
     */
    private function setupRepo(): array
    {
        return [
            'foo' => [
                '.git' => [
                    'config' => '# fake git config',
                    'hooks'  => [
                        'pre-commit.sample' => '# fake pre-commit sample file',
                        'pre-push.sample'   => '# fake pre-push sample file',
                        ]
                ],
                'some.txt' => '#fake file'
            ]
        ];
    }
}

<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\Diff;

use PHPUnit\Framework\TestCase;

/**
 * Class CompareTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 1.2.0
 */
class ChangedFilesTest extends TestCase
{
    /**
     * Tests ChangedFiles::getCommand
     */
    public function testChangedFilesInRange()
    {
        $changed = (new ChangedFiles())->tipToTip()
                                       ->fromRevision('1.0.0')
                                       ->toRevision('1.1.0');

        $this->assertEquals(
            'git diff --diff-algorithm=myers --name-only \'1.0.0\'..\'1.1.0\'',
            $changed->getCommand()
        );
    }

    /**
     * Tests ChangedFiles::getCommand
     */
    public function testChangedFilesSymmetric()
    {
        $changed = (new ChangedFiles())->mergeBase()
                                       ->fromRevision('1.0.0')
                                       ->toRevision('1.1.0');

        $this->assertEquals(
            'git diff --diff-algorithm=myers --name-only \'1.0.0\'...\'1.1.0\'',
            $changed->getCommand()
        );
    }

    /**
     * Tests ChangedFiles::getCommand
     */
    public function testChangedFilesWithFilter()
    {
        $changed = (new ChangedFiles())->tipToTip()
                                       ->fromRevision('1.0.0')
                                       ->toRevision('1.1.0')
                                       ->useFilter(['A', 'C', 'M']);

        $this->assertEquals(
            'git diff'
            . ' --diff-algorithm=myers --name-only'
            . ' --diff-filter=ACM \'1.0.0\'..\'1.1.0\'',
            $changed->getCommand()
        );
    }

    /**
     * Tests ChangedFiles::getCommand
     */
    public function testChangedFilesBySingleRevision()
    {
        $changed = (new ChangedFiles())->tipToTip()->fromRevision('1.0.0');

        $this->assertEquals(
            'git diff --diff-algorithm=myers --name-only \'1.0.0\'..head',
            $changed->getCommand()
        );
    }
}

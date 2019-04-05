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
use SebastianFeldmann\Git\Command\DiffTree\ChangedFiles;

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
    public function testChangedFilesByRevisions()
    {
        $changed = new ChangedFiles();
        $changed->fromRevision('1.0.0')
                ->toRevision('1.1.0');

        $this->assertEquals('git diff-tree --no-commit-id --name-only -r \'1.0.0\' \'1.1.0\'', $changed->getCommand());
    }

    /**
     * Tests ChangedFiles::getCommand
     */
    public function testChangedFilesBySingleRevision()
    {
        $changed = new ChangedFiles();
        $changed->fromRevision('1.0.0');

        $this->assertEquals('git diff-tree --no-commit-id --name-only -r \'1.0.0\'', $changed->getCommand());
    }
}

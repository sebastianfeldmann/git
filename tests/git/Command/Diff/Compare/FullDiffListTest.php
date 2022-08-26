<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\Diff\Compare;

use SebastianFeldmann\Git\Diff\File;
use SebastianFeldmann\Git\Diff\Line;
use PHPUnit\Framework\TestCase;

/**
 * Class FullDiffListTest
 *
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 1.2.0
 */
class FullDiffListTest extends TestCase
{
    /**
     * Tests FullDiffList::format
     */
    public function testFormatNewFile()
    {
        $output = [
            'diff --git a/some/File.php b/some/File.php',
            'new file mode 100644',
            'index 0000000..aba9789',
            '--- /dev/null',
            '+++ b/some/File.php',
            '@@ -0,0 +1,4 @@',
            '+<?php',
            '+class File',
            '+{',
            '+}'
        ];

        $formatter = new FullDiffList();
        $files     = $formatter->format($output);

        $this->assertCount(1, $files);
        $this->assertEquals('created', $files[0]->getOperation());
        $this->assertCount(4, $files[0]->getChanges()[0]->getLines());
        $this->assertEquals(Line::ADDED, $files[0]->getChanges()[0]->getLines()[0]->getOperation());
    }

    /**
     * Tests FullDiffList::format
     */
    public function testFormatNewFileStartingWithStupidEmptyLines()
    {
        $output = [
            '',
            '',
            'diff --git a/some/File.php b/some/File.php',
            'new file mode 100644',
            '',
            'index 0000000..aba9789',
            '--- /dev/null',
            '+++ b/some/File.php',
            '@@ -0,0 +1,5 @@',
            '+<?php',
            '+class File',
            '+{',
            '+}',
            ''
        ];

        $formatter = new FullDiffList();
        $files     = $formatter->format($output);

        $this->assertCount(1, $files);
        $this->assertEquals('created', $files[0]->getOperation());
        $this->assertCount(5, $files[0]->getChanges()[0]->getLines());
        $this->assertEquals(Line::ADDED, $files[0]->getChanges()[0]->getLines()[0]->getOperation());
    }

    /**
     * Tests FullDiffList::format
     */
    public function testFormatDeletedFile()
    {
        $output = [
            'diff --git a/some/File.php b/some/File.php',
            'deleted file mode 100644',
            'index 0000000..aba9789',
            '+++ a/some/File.php',
            '--- b/dev/null',
            '@@ -0,0 +1,4 @@',
            '-<?php',
            '-class File',
            '-{',
            '-}'
        ];

        $formatter = new FullDiffList();
        $files     = $formatter->format($output);

        $this->assertCount(1, $files);
        $this->assertEquals('deleted', $files[0]->getOperation());
        $this->assertCount(4, $files[0]->getChanges()[0]->getLines());
    }

    /**
     * Tests FullDiffList::format
     */
    public function testFormatMovedFile()
    {
        $output = [
            'diff --git a/some/Old.php b/some/New.php',
            'similarity index 95%',
            'rename from some/Old.php',
            'rename to some/New.php',
            'index 1b59b8f..aba9789',
            '+++ a/some/Old.php',
            '+++ b/some/New.php',
            '@@ -0,0 +1,4 @@',
            '-<?php',
            '-class New',
            '-{',
            '-}'
        ];

        $formatter = new FullDiffList();
        $files     = $formatter->format($output);

        $this->assertCount(1, $files);
        $this->assertEquals('renamed', $files[0]->getOperation());
        $this->assertCount(4, $files[0]->getChanges()[0]->getLines());
    }

    /**
     * Tests FullDiffList::format
     */
    public function testFormatModifiedFile()
    {
        $output = [
            'diff --git a/some/File.php b/some/File.php',
            'index 1b59b8f..aba9789',
            '+++ a/some/File.php',
            '+++ b/some/File.php',
            '@@ -0,0 +1,4 @@',
            '-<?php',
            '-class File',
            '-{',
            '-}'
        ];

        $formatter = new FullDiffList();
        $files     = $formatter->format($output);

        $this->assertCount(1, $files);
        $this->assertEquals('modified', $files[0]->getOperation());
        $this->assertCount(4, $files[0]->getChanges()[0]->getLines());
    }

    /**
     * Tests FullDiffList::format
     */
    public function testFormatModifiedFileMultipleChanges()
    {
        $output = [
            'diff --git a/some/File.php b/some/File.php',
            'index 1b59b8f..aba9789',
            '+++ a/some/File.php',
            '+++ b/some/File.php',
            '@@ -0,0 +1,3 @@',
            '+foo',
            '+bar',
            '+foo',
            '@@ -30,2 +30,0 @@',
            '-fiz',
            '-baz'
        ];

        $formatter = new FullDiffList();
        $files     = $formatter->format($output);

        $this->assertCount(1, $files);
        $this->assertEquals('modified', $files[0]->getOperation());
        $this->assertCount(2, $files[0]->getChanges());
        $this->assertCount(3, $files[0]->getChanges()[0]->getLines());
        $this->assertCount(2, $files[0]->getChanges()[1]->getLines());
    }

    /**
     * Tests FullDiffList::format
     */
    public function testFormatMultipleFile()
    {
        $output = [
            'diff --git a/some/A.php b/some/A.php',
            'index 1b59b8f..aba9789',
            '+++ a/some/A.php',
            '+++ b/some/A.php',
            '@@ -0,0 +1,4 @@',
            '-<?php',
            '-class A',
            '-{',
            '-}',
            'diff --git a/some/File.php b/some/File.php',
            'new file mode 100644',
            'index 0000000..aba9789',
            '--- /dev/null',
            '+++ b/some/File.php',
            '@@ -0,0 +1,5 @@',
            '+<?php',
            '+class File',
            '+{',
            '+    private $property;',
            '+}'
        ];

        $formatter = new FullDiffList();
        $files     = $formatter->format($output);

        $this->assertCount(2, $files);
        $this->assertEquals('modified', $files[0]->getOperation());
        $this->assertCount(4, $files[0]->getChanges()[0]->getLines());
        $this->assertEquals('created', $files[1]->getOperation());
        $this->assertCount(5, $files[1]->getChanges()[0]->getLines());
    }

    public function testFullDiffList01(): void
    {
        $output = file(__DIR__ . '/FullDiffList-01.diff', FILE_IGNORE_NEW_LINES);

        $formatter = new FullDiffList();

        /** @var File[] $files */
        $files = $formatter->format($output);

        $this->assertCount(5, $files);

        $firstFile = $files[0];
        $firstFileChanges = $firstFile->getChanges();

        $this->assertSame('src/Command/Diff/Compare.php', $firstFile->getName());
        $this->assertCount(5, $firstFileChanges);
        $this->assertSame(['from' => 67, 'to' => 0], $firstFileChanges[0]->getPre());
        $this->assertSame(['from' => 68, 'to' => 7], $firstFileChanges[0]->getPost());
        $this->assertSame(['from' => 80, 'to' => 0], $firstFileChanges[1]->getPre());
        $this->assertSame(['from' => 88, 'to' => 12], $firstFileChanges[1]->getPost());
        $this->assertSame(['from' => 83, 'to' => 0], $firstFileChanges[2]->getPre());
        $this->assertSame(['from' => 103, 'to' => 2], $firstFileChanges[2]->getPost());
        $this->assertSame(['from' => 89, 'to' => null], $firstFileChanges[3]->getPre());
        $this->assertSame(['from' => 110, 'to' => 13], $firstFileChanges[3]->getPost());
        $this->assertSame(['from' => 167, 'to' => null], $firstFileChanges[4]->getPre());
        $this->assertSame(['from' => 200, 'to' => 3], $firstFileChanges[4]->getPost());

        $secondFile = $files[1];
        $secondFileChanges = $secondFile->getChanges();

        $this->assertSame('src/Command/Diff/Compare/FullDiffList.php', $secondFile->getName());
        $this->assertCount(1, $secondFileChanges);
        $this->assertSame(['from' => 267, 'to' => null], $secondFileChanges[0]->getPre());
        $this->assertSame(['from' => 267, 'to' => null], $secondFileChanges[0]->getPost());

        $this->assertSame('src/Diff/Change.php', $files[2]->getName());
        $this->assertCount(6, $files[2]->getChanges());

        $this->assertSame('src/Operator/Diff.php', $files[3]->getName());
        $this->assertCount(2, $files[3]->getChanges());

        $this->assertSame('tests/git/Command/Diff/CompareTest.php', $files[4]->getName());
        $this->assertCount(8, $files[4]->getChanges());
    }

    public function testFullDiffListWithNoNewlineNotice(): void
    {
        $output = file(__DIR__ . '/FullDiffList-with-no-newline-notice.diff', FILE_IGNORE_NEW_LINES);

        $formatter = new FullDiffList();

        /** @var File[] $files */
        $files = $formatter->format($output);

        $this->assertCount(5, $files);

        $firstFile = $files[0];
        $firstFileChanges = $firstFile->getChanges();

        $this->assertSame('src/Command/Diff/Compare.php', $firstFile->getName());
        $this->assertCount(5, $firstFileChanges);
        $this->assertSame(['from' => 67, 'to' => 0], $firstFileChanges[0]->getPre());
        $this->assertSame(['from' => 68, 'to' => 7], $firstFileChanges[0]->getPost());
        $this->assertSame(['from' => 80, 'to' => 0], $firstFileChanges[1]->getPre());
        $this->assertSame(['from' => 88, 'to' => 12], $firstFileChanges[1]->getPost());
        $this->assertSame(['from' => 83, 'to' => 0], $firstFileChanges[2]->getPre());
        $this->assertSame(['from' => 103, 'to' => 2], $firstFileChanges[2]->getPost());
        $this->assertSame(['from' => 89, 'to' => null], $firstFileChanges[3]->getPre());
        $this->assertSame(['from' => 110, 'to' => 13], $firstFileChanges[3]->getPost());
        $this->assertSame(['from' => 167, 'to' => null], $firstFileChanges[4]->getPre());
        $this->assertSame(['from' => 200, 'to' => 3], $firstFileChanges[4]->getPost());

        $secondFile = $files[1];
        $secondFileChanges = $secondFile->getChanges();

        $this->assertSame('src/Command/Diff/Compare/FullDiffList.php', $secondFile->getName());
        $this->assertCount(1, $secondFileChanges);
        $this->assertSame(['from' => 267, 'to' => null], $secondFileChanges[0]->getPre());
        $this->assertSame(['from' => 267, 'to' => null], $secondFileChanges[0]->getPost());

        $this->assertSame('src/Diff/Change.php', $files[2]->getName());
        $this->assertCount(6, $files[2]->getChanges());

        $this->assertSame('src/Operator/Diff.php', $files[3]->getName());
        $this->assertCount(2, $files[3]->getChanges());

        $this->assertSame('tests/git/Command/Diff/CompareTest.php', $files[4]->getName());
        $this->assertCount(8, $files[4]->getChanges());
    }
}

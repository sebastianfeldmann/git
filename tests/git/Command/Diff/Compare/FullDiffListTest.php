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

/**
 * Class FullDiffListTest
 *
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 1.2.0
 */
class FullDiffListTest extends \PHPUnit\Framework\TestCase
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

        $this->assertEquals(1, count($files));
        $this->assertEquals('created', $files[0]->getOperation());
        $this->assertEquals(4, count($files[0]->getChanges()[0]->getLines()));
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

        $this->assertEquals(1, count($files));
        $this->assertEquals('created', $files[0]->getOperation());
        $this->assertEquals(5, count($files[0]->getChanges()[0]->getLines()));
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

        $this->assertEquals(1, count($files));
        $this->assertEquals('deleted', $files[0]->getOperation());
        $this->assertEquals(4, count($files[0]->getChanges()[0]->getLines()));
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

        $this->assertEquals(1, count($files));
        $this->assertEquals('renamed', $files[0]->getOperation());
        $this->assertEquals(4, count($files[0]->getChanges()[0]->getLines()));
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

        $this->assertEquals(1, count($files));
        $this->assertEquals('modified', $files[0]->getOperation());
        $this->assertEquals(4, count($files[0]->getChanges()[0]->getLines()));
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

        $this->assertEquals(1, count($files));
        $this->assertEquals('modified', $files[0]->getOperation());
        $this->assertEquals(2, count($files[0]->getChanges()));
        $this->assertEquals(3, count($files[0]->getChanges()[0]->getLines()));
        $this->assertEquals(2, count($files[0]->getChanges()[1]->getLines()));
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

        $this->assertEquals(2, count($files));
        $this->assertEquals('modified', $files[0]->getOperation());
        $this->assertEquals(4, count($files[0]->getChanges()[0]->getLines()));
        $this->assertEquals('created', $files[1]->getOperation());
        $this->assertEquals(5, count($files[1]->getChanges()[0]->getLines()));
    }
}

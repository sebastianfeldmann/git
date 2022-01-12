<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\DiffIndex\GetStagedFiles;

use PHPUnit\Framework\TestCase;

/**
 * Class FilterByStatusTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 0.9.0
 */
class FilterByStatusTest extends TestCase
{
    /**
     * Tests FilterByStatus::format
     */
    public function testFormat()
    {
        $string = 'A	.secret/treasure
A	src/Command/DiffIndex/GetStagedFiles.php
A	src/Command/Log/ChangedFilesSince.php
A	src/Command/Runner/Cli.php
D	src/Output/Formatter.php
A	src/Operator/Base.php
M	tests/git/Command/Log/LogTest.php';

        $output    = explode("\n", $string);
        $formatter = new FilterByStatus(['A', 'M']);
        $formatted = $formatter->format($output);

        $this->assertCount(6, $formatted);
    }

    /**
     * Tests FilterByStatus::format path extraction
     *
     * @covers \SebastianFeldmann\Git\Command\DiffIndex\GetStagedFiles\FilterByStatus
     */
    public function testExtractionOfPaths()
    {
        $string = "A\t.gitignore\nM\tsrc/Operator/Base.php";

        $output = explode("\n", $string);
        $expected = ['.gitignore', 'src/Operator/Base.php'];

        $formatter = new FilterByStatus(['A', 'M']);
        $actual = $formatter->format($output);
        $this->assertEquals($expected, $actual);
    }
}

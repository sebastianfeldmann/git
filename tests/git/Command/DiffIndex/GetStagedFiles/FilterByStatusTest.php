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

/**
 * Class FilterByStatusTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 0.9.0
 */
class FilterByStatusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests FilterByStatus::format
     */
    public function testFormat()
    {
        $string = 'A	src/Command/Base.php
A	src/Command/DiffIndex/GetStagedFiles.php
A	src/Command/Log/ChangedFilesSince.php
A	src/Command/Runner/Cli.php
D	src/Output/Formatter.php
A	src/Operator/Base.php
M	tests/git/Command/Log/LogTest.php';

        $output    = explode("\n", $string);
        $formatter = new FilterByStatus(['A', 'M']);
        $formatted = $formatter->format($output);

        $this->assertEquals(6, count($formatted));
    }
}

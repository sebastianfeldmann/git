<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\Status\Porcelain;

use PHPUnit\Framework\TestCase;
use SebastianFeldmann\Git\Status\Path;

/**
 * Class PathListTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release ?.?.?
 */
class PathListTest extends TestCase
{
    public function testFormat(): void
    {
        $output = [
            'R  LICENSE.md',
            'LICENSE',
            'A  LICENSE.txt',
            ' M composer.json',
            'AD composer.json.original',
            ' A foo bar.txt',
            'C  some-file.md',
            'some-file.txt',
            'M  phpstan.neon',
            ' M src/Operator/Index.php',
            'M  src/Repository.php',
            '?? foo"bar.txt',
            '?? føö bár.txt',
            '?? src/Command/Status/',
            '?? src/Operator/Status.php',
            '?? src/Status/',
            '?? tests/git/Command/Status/',
            '?? tests/git/Status/',
        ];

        // Combine into a NUL-byte separated string to represent status output
        // using `--porcelain=v1 -z`.
        $output = implode("\x00", $output) . "\x00";

        $formatter = new PathList();
        $formatted = $formatter->format([$output]);

        $this->assertContainsOnlyInstancesOf(Path::class, $formatted);
    }

    public function testFormatWithEmptyOutput(): void
    {
        $formatter = new PathList();
        $formatted = $formatter->format([]);

        $this->assertSame([], $formatted);
    }
}

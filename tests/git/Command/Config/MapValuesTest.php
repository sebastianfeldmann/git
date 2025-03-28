<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Command\Config;

use PHPUnit\Framework\TestCase;

/**
 * Class MapSettingsTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 1.0.8
 */
class MapValuesTest extends TestCase
{
    /**
     * Tests MapSettings::format
     */
    public function testFormat()
    {
        $string = 'credential.helper=osxkeychain
core.autocrlf=false
color.branch=auto
color.diff=auto
color.status=auto
alias.unstage=reset HEAD
alias.l=log --color --graph --pretty=format:\'%Cred%h%Creset ' .
                                   '-%C(yellow)%d%Creset %s %Cgreen(%cr) %C(bold blue)<%an>%Creset\' ' .
                                   '--abbrev-commit
alias.b=branch';

        $output    = explode("\n", $string);
        $formatter = new MapValues();
        $formatted = $formatter->format($output);

        $this->assertEquals('false', $formatted['core.autocrlf']);
        $this->assertEquals('auto', $formatted['color.status']);
        $this->assertEquals(
            'log --color --graph --pretty=format:\'%Cred%h%Creset ' .
            '-%C(yellow)%d%Creset %s %Cgreen(%cr) %C(bold blue)<%an>%Creset\' --abbrev-commit',
            $formatted['alias.l']
        );
    }
}

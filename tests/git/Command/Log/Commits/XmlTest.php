<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Command\Log\Commits;

use PHPUnit\Framework\TestCase;

/**
 * Class FullTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 3.2.0
 */
class XmlTest extends TestCase
{
    /**
     * Tests Full::parseLogOutput
     *
     * @throws \Exception
     */
    public function testParseLogOutput(): void
    {
        $out = '<commit>
<hash>11cd79f</hash>
<names><![CDATA[ (HEAD -> master, tag: 1.1.4, origin/master)]]></names>
<date>2020-01-17 22:10:30 +0100</date>
<author><![CDATA[Sebastian Feldmann]]></author>
<subject><![CDATA[Major fixup]]></subject>
<body><![CDATA[

]]></body>
</commit>
<commit>
<hash>11eb2b8</hash>
<names><![CDATA[]]></names>
<date>2020-01-17 22:10:06 +0100</date>
<author><![CDATA[Sebastian Feldmann]]></author>
<subject><![CDATA[Crash and burn]]></subject>
<body><![CDATA[

]]></body>
</commit>
<commit>
<hash>26fd241</hash>
<names><![CDATA[ (tag: 1.1.3)]]></names>
<date>2020-01-17 22:07:55 +0100</date>
<author><![CDATA[Sebastian Feldmann]]></author>
<subject><![CDATA[Fixed tpyo]]></subject>
<body><![CDATA[

]]></body>
</commit>
<commit>
<hash>0241f2c</hash>
<names><![CDATA[ (tag: 1.1.2)]]></names>
<date>2020-01-17 22:00:20 +0100</date>
<author><![CDATA[Sebastian Feldmann]]></author>
<subject><![CDATA[Best commit ever]]></subject>
<body><![CDATA[
This is a multiline commit message.
]]></body>
</commit>';

        $log = Xml::parseLogOutput($out);

        $this->assertCount(4, $log);
        $this->assertCount(3, $log[0]->getNames());
        $this->assertFalse($log[1]->hasNames());
        $this->assertEquals('origin/master', $log[0]->getNames()[2]);
        $this->assertEquals('Major fixup', $log[0]->getSubject());
        $this->assertEquals('This is a multiline commit message.', $log[3]->getBody());
    }
}

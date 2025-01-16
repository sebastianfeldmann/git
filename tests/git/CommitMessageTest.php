<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git;

use PHPUnit\Framework\TestCase;

/**
 * Class CommitMessageTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 0.9.0
 */
class CommitMessageTest extends TestCase
{
    /**
     * Tests CommitMessage::isEmpty
     */
    public function testIsEmpty()
    {
        $msg = new CommitMessage('');

        $this->assertTrue($msg->isEmpty());
    }

    /**
     * Tests CommitMessage::isFixup
     */
    public function testIsFixup()
    {
        $msg = new CommitMessage('Some stuff');
        $this->assertFalse($msg->isFixup());

        $msg = new CommitMessage('fixup! Some stuff');
        $this->assertTrue($msg->isFixup());
    }

    /**
     * Tests CommitMessage::isSquash
     */
    public function testIsSquash()
    {
        $msg = new CommitMessage('Some stuff');
        $this->assertFalse($msg->isSquash());

        $msg = new CommitMessage('squash! Some stuff');
        $this->assertTrue($msg->isSquash());
    }

    /**
     * Tests CommitMessage::getSubject
     */
    public function testGetSubjectOnEmptyMessage()
    {
        $msg = new CommitMessage('');

        $this->assertEquals('', $msg->getSubject());
    }

    /**
     * Tests CommitMessage::isEmpty
     */
    public function testIsEmptyDoesNotIncludeComments()
    {
        $msg = new CommitMessage('# Testing', '#');

        $this->assertTrue($msg->isEmpty());
    }

    /**
     * Tests CommitMessage::getContent
     */
    public function testGetContent()
    {
        $content = 'Foo' . PHP_EOL . 'Bar' . PHP_EOL . 'Baz';
        $msg = new CommitMessage($content);

        $this->assertEquals($content, $msg->getContent());
    }

    /**
     * Tests CommitMessage::getContent
     */
    public function testGetContentExcludesComments()
    {
        $content = 'Foo' . PHP_EOL . '# Bar' . PHP_EOL . 'Baz';
        $msg = new CommitMessage($content, '#');

        $this->assertEquals('Foo' . PHP_EOL . 'Baz', $msg->getContent());
    }

    /**
     * Tests CommitMessage::getContent
     */
    public function testGetContentWithScissors()
    {
        $content = 'Foo' . PHP_EOL . '# Bar' . PHP_EOL . 'Baz' . PHP_EOL .
                   '# ------------------------ >8 ------------------------' . PHP_EOL .
                   'fiz' . PHP_EOL . 'baz';

        $msg = new CommitMessage($content);
        $this->assertEquals(2, $msg->getContentLineCount());
        $this->assertEquals('Foo' . PHP_EOL . 'Baz', $msg->getContent());
    }

    /**
     * Tests CommitMessage::getComments
     */
    public function testGetCommentsExcludesContent()
    {
        $content = 'Foo' . PHP_EOL . '# Fiz' . PHP_EOL . 'Bar' . PHP_EOL . '# Baz';
        $msg = new CommitMessage($content, '#');

        $this->assertEquals('# Fiz' . PHP_EOL . '# Baz', $msg->getComments());
    }

    /**
     * Tests CommitMessage::getComments
     */
    public function testGetCommentsWithScissors()
    {
        $content = 'Foo' . PHP_EOL . '# Bar' . PHP_EOL . 'Baz' . PHP_EOL .
                   '# ------------------------ >8 ------------------------' . PHP_EOL .
                   'fiz' . PHP_EOL . 'baz';
        $expected = '# Bar' . PHP_EOL .
                    '# ------------------------ >8 ------------------------' . PHP_EOL .
                    'fiz' . PHP_EOL . 'baz';

        $msg = new CommitMessage($content, '#');
        $this->assertEquals($expected, $msg->getComments());
    }

    /**
     * Tests CommitMessage::getRawContent
     */
    public function testGetRawContentIncludesComments()
    {
        $content = 'Foo' . PHP_EOL . '# Bar' . PHP_EOL . 'Baz';
        $msg     = new CommitMessage($content, '#');

        $this->assertEquals($content, $msg->getRawContent());
    }

    /**
     * Tests CommitMessage::getLines
     */
    public function testGetLines()
    {
        $msg   = new CommitMessage('Foo' . PHP_EOL . 'Bar' . PHP_EOL . 'Baz');
        $lines = $msg->getLines();

        $this->assertIsArray($lines);
        $this->assertCount(3, $lines);
    }

    /**
     * Tests CommitMessage::getLines
     */
    public function testGetLinesIncludesComments()
    {
        $msg   = new CommitMessage('Foo' . PHP_EOL . '# Bar' . PHP_EOL . 'Baz', '#');
        $lines = $msg->getLines();

        $this->assertIsArray($lines);
        $this->assertCount(3, $lines);
    }

    /**
     * Tests CommitMessage::getLineCount
     */
    public function testLineCodeOnEmptyMessage()
    {
        $msg = new CommitMessage('');

        $this->assertEquals(0, $msg->getLineCount());
    }

    /**
     * Tests CommitMessage::getLineCount
     */
    public function testLineCount()
    {
        $msg = new CommitMessage('Foo' . PHP_EOL . 'Bar' . PHP_EOL . 'Baz');

        $this->assertEquals(3, $msg->getLineCount());
    }

    /**
     * Tests CommitMessage::getLineCount
     */
    public function testRawLineCountIncludesComments()
    {
        $msg = new CommitMessage('Foo' . PHP_EOL . '# Bar' . PHP_EOL . 'Baz', '#');

        $this->assertEquals(3, $msg->getLineCount());
    }

    /**
     * Tests CommitMessage::getContentLineCount
     */
    public function testContentLineCount()
    {
        $msg = new CommitMessage('Foo' . PHP_EOL . '# Bar' . PHP_EOL . 'Baz', '#');

        $this->assertEquals(2, $msg->getContentLineCount());
    }

    /**
     * Tests CommitMessage::getSubject
     */
    public function testGetSubject()
    {
        $msg = new CommitMessage('Foo' . PHP_EOL . 'Bar' . PHP_EOL . 'Baz');

        $this->assertEquals('Foo', $msg->getSubject());
    }

    /**
     * Tests CommitMessage::getSubject
     */
    public function testGetSubjectDoesNotIncludeComments()
    {
        $msg = new CommitMessage('# Foo' . PHP_EOL . 'Bar' . PHP_EOL . 'Baz', '#');

        $this->assertEquals('Bar', $msg->getSubject());
    }

    /**
     * Tests CommitMessage::getBody
     */
    public function testGetBody()
    {
        $msg = new CommitMessage('Foo' . PHP_EOL . PHP_EOL . 'Bar' . PHP_EOL . 'Baz');

        $this->assertEquals('Bar' . PHP_EOL . 'Baz', $msg->getBody());
    }

    /**
     * Tests CommitMessage::getBody
     */
    public function testGetBodyDoesNotIncludeComments()
    {
        $msg = new CommitMessage('Foo' . PHP_EOL . PHP_EOL . '# Bar' . PHP_EOL . 'Baz', '#');

        $this->assertEquals('Baz', $msg->getBody());
    }

    /**
     * Tests CommitMessage::getBodyLines
     */
    public function testGetBodyLines()
    {
        $msg   = new CommitMessage('Foo' . PHP_EOL . PHP_EOL . 'Bar' . PHP_EOL . 'Baz');
        $lines = $msg->getBodyLines();

        $this->assertCount(2, $lines);
        $this->assertEquals('Bar', $lines[0]);
        $this->assertEquals('Baz', $lines[1]);
    }
    /**
     * Tests CommitMessage::getBodyLines
     */
    public function testGetBodyLinesDoesNotIncludeComments()
    {
        $msg   = new CommitMessage('Foo' . PHP_EOL . PHP_EOL . '# Bar' . PHP_EOL . 'Baz', '#');
        $lines = $msg->getBodyLines();

        $this->assertCount(1, $lines);
        $this->assertEquals('Baz', $lines[0]);
    }

    /**
     * Tests CommitMessage::getLine
     */
    public function testGetLine()
    {
        $msg = new CommitMessage('Foo' . PHP_EOL . 'Bar' . PHP_EOL . 'Baz');

        $this->assertEquals('Foo', $msg->getLine(0));
        $this->assertEquals('Bar', $msg->getLine(1));
        $this->assertEquals('Baz', $msg->getLine(2));
    }

    /**
     * Tests CommitMessage::getLines
     */
    public function testGetContentLine()
    {
        $msg = new CommitMessage('Foo' . PHP_EOL . '# Bar' . PHP_EOL . 'Baz');

        $this->assertEquals('Foo', $msg->getContentLine(0));
        $this->assertEquals('Baz', $msg->getContentLine(1));
        $this->assertEquals('', $msg->getContentLine(2));
    }

    /**
     * Tests CommitMessage::getLine
     */
    public function testGetLineIncludesCommentLines()
    {
        $msg = new CommitMessage('Foo' . PHP_EOL . '# Bar' . PHP_EOL . 'Baz', '#');

        $this->assertEquals('Foo', $msg->getLine(0));
        $this->assertEquals('# Bar', $msg->getLine(1));
        $this->assertEquals('Baz', $msg->getLine(2));
    }

    /**
     * Tests CommitMessage::createFromFile
     */
    public function testCreateFromFileFail()
    {
        $this->expectException(\Exception::class);
        CommitMessage::createFromFile('iDoNotExist.txt');
    }

    /**
     * Tests CommitMessage::createFromFile
     */
    public function testCreateFromEmptyPathFail()
    {
        $this->expectException(\Exception::class);
        CommitMessage::createFromFile('');
    }

    /**
     * Tests CommitMessage::createFromFile
     */
    public function testCreateFromFileOk()
    {
        $message = CommitMessage::createFromFile(SF_GIT_PATH_FILES . '/git/message/valid.txt');

        $this->assertEquals('This is a valid dummy commit Message', $message->getSubject());
    }

    /**
     * Tests CommitMessage::createFromFile
     */
    public function testCreateFromFileSkipsCommentsByDefault()
    {
        $message = CommitMessage::createFromFile(
            SF_GIT_PATH_FILES . '/git/message/valid-with-comments.txt'
        );

        $this->assertStringNotContainsString(
            'Please enter the commit message for your changes. Lines starting',
            $message->getBody()
        );
    }

    /**
     * Tests CommitMessage::getCommentCharacter
     */
    public function testGetCommentCharacter()
    {
        $msg = new CommitMessage('Content', '#');

        $this->assertEquals('#', $msg->getCommentCharacter());
    }
}

<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Operator;

use RuntimeException;
use SebastianFeldmann\Cli\Command\Result as CommandResult;
use SebastianFeldmann\Cli\Command\Runner\Result as RunnerResult;

/**
 * Class ConfigTest
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 1.0.2
 */
class ConfigTest extends OperatorTest
{
    /**
     * Tests Config::has
     */
    public function testHas()
    {
        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git ...', 0, '#');
        $result = new RunnerResult($cmd);

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));
        $runner->method('run')->willReturn($result);

        $config = new Config($runner, $repo);
        $hasKey = $config->has('core.commentchar');

        $this->assertTrue($hasKey);
    }

    /**
     * Tests Config::hasVar
     */
    public function testHasVar()
    {
        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git ...', 0, '#');
        $result = new RunnerResult($cmd);

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));
        $runner->method('run')->willReturn($result);

        $config = new Config($runner, $repo);
        $hasVar = $config->hasVar('core.commentchar');
        $this->assertTrue($hasVar);
    }

    /**
     * Tests Config::has
     */
    public function testHasNot()
    {
        $repo      = $this->getRepoMock();
        $runner    = $this->getRunnerMock();
        $exception = new RuntimeException(
            'Command failed: git config \'core.commentchar\'' . PHP_EOL
            . '  exit-code: 1' . PHP_EOL
            . '  message:   ' . PHP_EOL,
            1
        );

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));
        $runner->method('run')
               ->will($this->throwException($exception));

        $config = new Config($runner, $repo);
        $hasKey = $config->has('core.commentchar');

        $this->assertFalse($hasKey);
    }

    /**
     * @tests Config::hasVar
     */
    public function testHasVarNot()
    {
        $repo      = $this->getRepoMock();
        $runner    = $this->getRunnerMock();
        $exception = new RuntimeException(
            'Command failed: git config \'core.commentchar\'' . PHP_EOL
            . '  exit-code: 1' . PHP_EOL
            . '  message:   ' . PHP_EOL,
            1
        );

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));
        $runner->method('run')
            ->will($this->throwException($exception));

        $config = new Config($runner, $repo);
        $hasKey = $config->hasVar('core.commentchar');

        $this->assertFalse($hasKey);
    }

    /**
     * Tests Config::get
     */
    public function testGet()
    {
        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd = new CommandResult('git ...', 0, '#');
        $result = new RunnerResult($cmd);

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));
        $runner->method('run')->willReturn($result);

        $config = new Config($runner, $repo);
        $value = $config->get('core.commentchar');

        $this->assertEquals('#', $value);
    }

    /**
     * Tests Config::getVar
     */
    public function testGetVar()
    {
        $repo = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd = new CommandResult('git ...', 0, '#');
        $result = new RunnerResult($cmd);

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));
        $runner->method('run')->willReturn($result);

        $config = new Config($runner, $repo);
        $value = $config->getVar('core.commentchar');

        $this->assertEquals('#', $value);
    }


    /**
     * Tests Config::getSafely
     */
    public function testGetSafelyNotSet()
    {
        $repo      = $this->getRepoMock();
        $runner    = $this->getRunnerMock();
        $exception = new RuntimeException(
            'Command failed: git config \'core.commentchar\'' . PHP_EOL
            . '  exit-code: 1' . PHP_EOL
            . '  message:   ' . PHP_EOL,
            1
        );

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));
        $runner->method('run')
               ->will($this->throwException($exception));

        $config = new Config($runner, $repo);
        $getKey = $config->getSafely('core.invalid', 'valid');

        $this->assertEquals('valid', $getKey);
    }

    /**
     * Tests Config::getVarSafely
     */
    public function testGetVarSafelyNotSet()
    {
        $repo      = $this->getRepoMock();
        $runner    = $this->getRunnerMock();
        $exception = new RuntimeException(
            'Command failed: git config \'core.commentchar\'' . PHP_EOL
            . '  exit-code: 1' . PHP_EOL
            . '  message:   ' . PHP_EOL,
            1
        );

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));
        $runner->method('run')
            ->will($this->throwException($exception));

        $config = new Config($runner, $repo);
        $getKey = $config->getVarSafely('core.invalid', 'valid');

        $this->assertEquals('valid', $getKey);
    }

    /**
     * Tests Config::getSafely
     */
    public function testGetSettingSafelySet()
    {
        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git ...', 0, '#');
        $result = new RunnerResult($cmd);

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));
        $runner->method('run')->willReturn($result);

        $config = new Config($runner, $repo);
        $getKey = $config->getSafely('core.commentchar', '#');

        $this->assertEquals('#', $getKey);
    }

    /**
     * Tests Config::getSafely
     */
    public function testGetVarSafelySet()
    {
        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git ...', 0, '#');
        $result = new RunnerResult($cmd);

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));
        $runner->method('run')->willReturn($result);

        $config = new Config($runner, $repo);
        $getKey = $config->getVarSafely('core.commentchar', '#');

        $this->assertEquals('#', $getKey);
    }

    /**
     * Tests Config::getSettings
     */
    public function testGetSettings()
    {
        $out    = ['core.autocrlf' => 'false', 'color.branch' => 'auto', 'color.diff' => 'auto'];
        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git config --list', 0, '');
        $result = new RunnerResult($cmd, $out);

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));
        $runner->method('run')->willReturn($result);

        $config   = new Config($runner, $repo);
        $settings = $config->getSettings();

        $this->assertEquals('false', $settings['core.autocrlf']);
        $this->assertEquals('auto', $settings['color.branch']);
        $this->assertEquals('auto', $settings['color.diff']);
    }

    /**
     * Tests Config::getVars
     */
    public function testGetVars()
    {
        $out    = ['core.autocrlf' => 'false', 'color.branch' => 'auto', 'color.diff' => 'auto'];
        $repo   = $this->getRepoMock();
        $runner = $this->getRunnerMock();
        $cmd    = new CommandResult('git config --list', 0, '');
        $result = new RunnerResult($cmd, $out);

        $repo->method('getRoot')->willReturn((string) realpath(__FILE__ . '/../../..'));
        $runner->method('run')->willReturn($result);

        $config = new Config($runner, $repo);
        $vars   = $config->getVars();

        $this->assertEquals('false', $vars['core.autocrlf']);
        $this->assertEquals('auto', $vars['color.branch']);
        $this->assertEquals('auto', $vars['color.diff']);
    }
}

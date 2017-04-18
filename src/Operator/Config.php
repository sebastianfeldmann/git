<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian.feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Operator;

use SebastianFeldmann\Cli\Command\Runner\Result;
use SebastianFeldmann\Git\Command\Config\Get;

/**
 * Class Config
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 */
class Config extends Base
{
    /**
     * Does git have a configuration key
     *
     * @param  string $name
     * @return boolean
     */
    public function has(string $name) : bool
    {
        $result = $this->configCommand($name);

        return $result->isSuccessful();
    }


    /**
     * Get a configuration key value
     *
     * @param  string $name
     * @return string
     */
    public function get(string $name) : string
    {
        $result = $this->configCommand($name);

        return $result->getBufferedOutput()[0];
    }

    /**
     * Run the get config command
     *
     * @param string $name
     * @return \SebastianFeldmann\Cli\Command\Runner\Result
     */
    private function configCommand(string $name) : Result
    {
        $cmd = (new Get($this->repo->getRoot()));
        $cmd->name($name);

        $result = $this->runner->run($cmd);

        return $result;
    }
}

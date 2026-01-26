<?php

/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Git\Rev;

use SebastianFeldmann\Git\Rev;

/**
 * Generic range implementation
 *
 * The simplest imaginable range implementation without any extra information.
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 3.16.0
 */
class Generic implements Rev
{
    /**
     * Referencing a git state
     *
     * @var string
     */
    private string $id;

    /**
     * Constructor
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * Return the git reference
     *
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }
}

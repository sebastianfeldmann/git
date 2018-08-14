<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Diff;

/**
 * Class File
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 1.2.0
 */
class File
{
    const OP_DELETED  = 'deleted';
    const OP_CREATED  = 'created';
    const OP_MODIFIED = 'modified';
    const OP_RENAMED  = 'renamed';
    const OP_COPIED   = 'copied';

    /**
     * List of changes.
     *
     * @var \SebastianFeldmann\Git\Diff\Change[]
     */
    private $changes = [];

    /**
     * Filename
     *
     * @var string
     */
    private $name;

    /**
     * Operation performed on the file.
     *
     * @var string
     */
    private $operation;

    /**
     * File constructor.
     *
     * @param string $name
     * @param string $operation
     */
    public function __construct(string $name, string $operation)
    {
        $this->operation = $operation;
        $this->name      = $name;
    }

    /**
     * Returns the filename.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the performed operation.
     *
     * @return string
     */
    public function getOperation(): string
    {
        return $this->operation;
    }

    /**
     * Returns the list of changes in this file.
     *
     * @return \SebastianFeldmann\Git\Diff\Change[]
     */
    public function getChanges(): array
    {
        return $this->changes;
    }

    /**
     * Add a change to the list of changes.
     *
     * @param \SebastianFeldmann\Git\Diff\Change $change
     */
    public function addChange(Change $change)
    {
        $this->changes[] = $change;
    }
}

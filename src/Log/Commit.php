<?php
/**
 * This file is part of SebastianFeldmann\Git.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Git\Log;

/**
 * Class Commit
 *
 * @package SebastianFeldmann\Git
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/git
 * @since   Class available since Release 1.2.0
 */
class Commit
{
    /**
     * @var string
     */
    private $hash;

    /**
     * @var array
     */
    private $names;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTimeImmutable
     */
    private $date;

    /**
     * @var string
     */
    private $author;

    /**
     * Commit constructor.
     *
     * @param string             $hash
     * @param array              $names
     * @param string             $description
     * @param \DateTimeImmutable $date
     * @param string             $author
     */
    public function __construct(
        string $hash,
        array $names,
        string $description,
        \DateTimeImmutable $date,
        string $author
    )
    {
        $this->hash        = $hash;
        $this->names       = $names;
        $this->description = $description;
        $this->date        = $date;
        $this->author      = $author;
    }

    /**
     * Hash getter.
     *
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * Does the commit have names.
     *
     * @return bool
     */
    public function hasNames(): bool
    {
        return !empty($this->names);
    }

    /**
     * Names getter.
     *
     * @return array
     */
    public function getNames(): array
    {
        return $this->names;
    }

    /**
     * Description getter.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Date getter.
     *
     * @return \DateTimeImmutable
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * Author getter.
     *
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }
}

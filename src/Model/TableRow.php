<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTracker\Model;

class TableRow
{
    /**
     * @var bool
     */
    private $isHead;
    /**
     * @var array
     */
    private $columns = [];

    /**
     * @param bool $isHead
     * @param string[] $text
     */
    public function __construct(bool $isHead, string ...$text)
    {
        $this->isHead = $isHead;
        array_push($this->columns, ...$text);
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @return int
     */
    public function getColumnsCount(): int
    {
        return count($this->columns);
    }

    /**
     * @return bool
     */
    public function isHead(): bool
    {
        return $this->isHead;
    }
}

<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTracker\Renderer;

use Stahlstift\TimeTracker\Model\TableRow;

class Console implements Renderer
{

    /**
     * @param TableRow[] $rows
     *
     * @return array
     */
    private function calculateTableData(array $rows): array
    {
        $totalColumns = 0;
        $columnsLength = [];

        foreach ($rows as $row) {
            if ($totalColumns < $row->getColumnsCount()) {
                $totalColumns = $row->getColumnsCount();
            }

            foreach ($row->getColumns() as $colNum => $columnText) {
                if (!isset($columnsLength[$colNum])) {
                    $columnsLength[$colNum] = 0;
                }

                $tmp = strlen($columnText);
                if ($columnsLength[$colNum] < $tmp) {
                    $columnsLength[$colNum] = $tmp;
                }
            }
        }

        return [$totalColumns, $columnsLength];
    }

    /**
     * @param int $totalColumns
     * @param array $columnsLength
     * @param array $columns
     *
     * @return string
     */
    private function createLine(int $totalColumns, array $columnsLength, array $columns): string
    {
        $retVal = '';
        for ($colNum = 0; $colNum < $totalColumns; $colNum++) {
            if (isset($columns[$colNum])) {
                $retVal .= '║ ' . $columns[$colNum];
                $spaces = $columnsLength[$colNum] - strlen($columns[$colNum]);
                $retVal .= str_repeat(' ', $spaces + 1);
            } else {
                $retVal = str_repeat(' ', $columnsLength[$colNum] + 1);
            }

            if ($colNum == ($totalColumns - 1)) {
                $retVal .= '║';
            }
        }

        $retVal .= PHP_EOL;

        return $retVal;
    }

    /**
     * @param int $totalColumns
     * @param array $columnsLength
     * @param array $columns
     *
     * @return string
     */
    private function createHeader(int $totalColumns, array $columnsLength, array $columns): string
    {
        $retVal = '╔';
        foreach ($columnsLength as $colNum => $length) {
            $retVal .= str_repeat("═", $length + 2);

            if ($colNum < ($totalColumns - 1)) {
                $retVal .= '╦';
            } else {
                $retVal .= '╗';
            }
        }

        $retVal .= PHP_EOL;

        $retVal .= $this->createLine($totalColumns, $columnsLength, $columns);

        $retVal .= '╠';
        foreach ($columnsLength as $colNum => $length) {
            $retVal .= str_repeat("═", $length + 2);

            if ($colNum < ($totalColumns - 1)) {
                $retVal .= '╬';
            } else {
                $retVal .= '╣';
            }
        }

        $retVal .= PHP_EOL;

        return $retVal;
    }

    /**
     * @param int $totalColumns
     * @param array $columnsLength
     *
     * @return string
     */
    private function createFooter(int $totalColumns, array $columnsLength): string
    {
        $retVal = '╚';
        foreach ($columnsLength as $colNum => $length) {
            $retVal .= str_repeat("═", $length + 2);

            if ($colNum < ($totalColumns - 1)) {
                $retVal .= '╩';
            } else {
                $retVal .= '╝';
            }
        }

        $retVal .= PHP_EOL;

        return $retVal;
    }

    /**
     * @see https://de.wikipedia.org/wiki/Unicodeblock_Rahmenzeichnung
     *
     * @param \Stahlstift\TimeTracker\Model\TableRow[] $rows
     *
     * @return string
     */
    private function createTable(array $rows): string
    {
        list($totalColumns, $columnsLength) = $this->calculateTableData($rows);

        $retVal = '';
        foreach ($rows as $row) {
            $columns = $row->getColumns();

            if ($row->isHead()) {
                $retVal .= $this->createHeader($totalColumns, $columnsLength, $columns);
            } else {
                $retVal .= $this->createLine($totalColumns, $columnsLength, $columns);
            }
        }

        $retVal .= $this->createFooter($totalColumns, $columnsLength);

        return $retVal;
    }

    /**
     * @param string $title
     * @param TableRow[] $rows
     */
    public function renderResult(string $title, array $rows)
    {
        echo PHP_EOL;
        echo $title;
        echo PHP_EOL;
        echo $this->createTable($rows);
        echo PHP_EOL;
    }
}

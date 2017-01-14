<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTracker\Output;

class Console
{

    public function nextLine()
    {
        echo PHP_EOL;
    }

    /**
     * @param string $text
     */
    public function printText(string $text)
    {
        echo $text;
    }

    /**
     * @param TableRow[] $rows
     *
     * @see https://de.wikipedia.org/wiki/Unicodeblock_Rahmenzeichnung
     */
    public function printTable(array $rows)
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

        foreach ($rows as $row) {
            $columns = $row->getColumns();

            if ($row->isHead()) {
                $text = '╔';
                foreach ($columnsLength as $colNum => $length) {
                    $text .= str_repeat("═", $length + 2);

                    if ($colNum < ($totalColumns - 1)) {
                        $text .= '╦';
                    } else {
                        $text .= '╗';
                    }
                }

                $this->printText($text);
                $this->nextLine();
            }

            for ($colNum = 0; $colNum < $totalColumns; $colNum++) {
                if (isset($columns[$colNum])) {
                    $text = '║ ' . $columns[$colNum];
                    $spaces = $columnsLength[$colNum] - strlen($columns[$colNum]);
                    $text .= str_repeat(' ', $spaces + 1);
                } else {
                    $text = str_repeat(' ', $columnsLength[$colNum] + 1);
                }

                if ($colNum == ($totalColumns - 1)) {
                    $text .= '║';
                }

                $this->printText($text);
            }

            $this->nextLine();

            if ($row->isHead()) {
                $text = '╠';
                foreach ($columnsLength as $colNum => $length) {
                    $text .= str_repeat("═", $length + 2);

                    if ($colNum < ($totalColumns - 1)) {
                        $text .= '╬';
                    } else {
                        $text .= '╣';
                    }
                }

                $this->printText($text);
                $this->nextLine();
            }
        }

        $text = '╚';
        foreach ($columnsLength as $colNum => $length) {
            $text .= str_repeat("═", $length + 2);

            if ($colNum < ($totalColumns - 1)) {
                $text .= '╩';
            } else {
                $text .= '╝';
            }
        }

        $this->printText($text);
        $this->nextLine();
    }
}

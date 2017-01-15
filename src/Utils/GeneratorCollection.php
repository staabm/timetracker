<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTracker\Utils;

use Generator;
use Iterator;

class GeneratorCollection
{

    /**
     * @param string $path
     *
     * @return Generator
     */
    public function readLinesFromFile(string $path): Generator
    {
        $handle = fopen($path, 'r');

        try {
            while ($data = stream_get_line($handle, 512, "\n")) {
                yield $data;
            }
        } finally {
            fclose($handle);
        }
    }

    /**
     * @param Iterator|array $iterator
     * @param string $regex
     *
     * @return Generator
     */
    public function filterWithRegex($iterator, string $regex): Generator
    {
        foreach ($iterator as $value) {
            if (preg_match($regex, $value)) {
                yield $value;
            }
        }
    }
}

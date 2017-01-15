<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTracker\Utils;

use Generator;
use Traversable;

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
     * @param Traversable $traversable
     * @param string $regex
     *
     * @return Generator
     */
    public function filterWithRegex(Traversable $traversable, string $regex): Generator
    {
        foreach ($traversable as $value) {
            if (preg_match($regex, $value)) {
                yield $value;
            }
        }
    }
}

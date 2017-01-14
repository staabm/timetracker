<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTracker;

use DateTimeImmutable;
use Generator;
use Traversable;

class Parser
{

    /**
     * @var string
     */
    private $dbPath = '';

    /**
     * @param string $dbPath
     */
    public function __construct(string $dbPath)
    {
        // todo: exception und oder testbar
        $this->createPath($dbPath);
        $this->dbPath = $dbPath;
    }

    /**
     * @param string $path
     */
    private function createPath(string $path)
    {
        $dir = pathinfo($path, PATHINFO_DIRNAME);
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }

        if (!is_file($path)) {
            touch($path);
        }
    }

    /**
     * @param string $username
     * @param string $ticket
     * @param int $durationInSeconds
     * @param DateTimeImmutable $date
     */
    public function track(string $username, string $ticket, int $durationInSeconds, DateTimeImmutable $date)
    {
        $dataset = [
            $date->format('Y-m-d'),
            $ticket,
            $username,
            $durationInSeconds,
            'id_' . mt_rand(),
        ];
        file_put_contents($this->dbPath, implode(',', $dataset) . "\n", FILE_APPEND | FILE_TEXT);
    }

    /**
     * @param string $userfilter
     * @param string $ticketFilter
     * @param string $dateFilter
     *
     * @return Generator
     */
    public function filter(string $userfilter = '', string $ticketFilter = '', string $dateFilter = ''): Generator
    {
        $readLineFile = function (string $path) {
            $handle = fopen($path, 'r');

            try {
                while ($data = stream_get_line($handle, 512, "\n")) {
                    yield $data;
                }
            } finally {
                fclose($handle);
            }
        };

        $regexFilter = function (Traversable $iter, string $regex) {
            foreach ($iter as $value) {
                if (preg_match($regex, $value)) {
                    yield $value;
                }
            }
        };

        $regEx = '/^';

        $filterArray = [];
        $filterArray[] = ($dateFilter) ? ($dateFilter) : ('.*?');
        $filterArray[] = ($ticketFilter) ? ($ticketFilter) : ('.*?');
        $filterArray[] = ($userfilter) ? ($userfilter) : ('.*?');

        $regEx .= implode(',', $filterArray);
        $regEx .= '.*/';

        return $regexFilter($readLineFile($this->dbPath), $regEx);
    }

}
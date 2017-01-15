<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTracker;

use DateTimeInterface;
use Stahlstift\TimeTracker\Exception\Exception;
use Stahlstift\TimeTracker\Utils\FileSystem;
use Stahlstift\TimeTracker\Utils\GeneratorCollection;
use Traversable;

class Parser
{

    /**
     * @var FileSystem
     */
    private $fileSystem;
    /**
     * @var string
     */
    private $dbPath = '';
    /**
     * @var GeneratorCollection
     */
    private $gen;

    /**
     * @param FileSystem $fileSystem
     * @param string $dbPath
     * @param GeneratorCollection $gen
     */
    public function __construct(FileSystem $fileSystem, string $dbPath, GeneratorCollection $gen)
    {
        $this->fileSystem = $fileSystem;
        $this->dbPath = $dbPath;
        $this->gen = $gen;
    }

    /**
     * @throws Exception
     */
    public function init()
    {
        $this->fileSystem->createPath($this->dbPath);
    }

    /**
     * @param string $username
     * @param string $ticket
     * @param int $durationInSeconds
     * @param DateTimeInterface $date
     */
    public function track(string $username, string $ticket, int $durationInSeconds, DateTimeInterface $date)
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
     * @param string $userFilter
     * @param string $ticketFilter
     * @param string $dateFilter
     *
     * @return Traversable
     */
    public function filter(string $userFilter = '', string $ticketFilter = '', string $dateFilter = ''): Traversable
    {
        $regEx = '/^';

        $filterArray = [];
        $filterArray[] = ($dateFilter) ? ($dateFilter) : ('.*?');
        $filterArray[] = ($ticketFilter) ? ($ticketFilter) : ('.*?');
        $filterArray[] = ($userFilter) ? ($userFilter) : ('.*?');

        $regEx .= implode(',', $filterArray);
        $regEx .= '.*/';

        return $this->gen->filterWithRegex(
            $this->gen->readLinesFromFile($this->dbPath),
            $regEx
        );
    }
}

<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTracker\Model;

class Duration
{

    const SPACE = '    ';
    const FORMAT = '%02d%s ';
    const UNIT_WEEKS = 'w';
    const UNIT_DAYS = 'd';
    const UNIT_HOURS = 'h';
    const UNIT_MINUTES = 'm';
    const UNIT_SECONDS = 's';

    /**
     * @var int
     */
    private $seconds = 0;

    /**
     * @param int $seconds
     */
    public function __construct(int $seconds)
    {
        $this->seconds = $seconds;
    }

    /**
     * @return string 01w 04d 20h 10m 34s
     *
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function getTimeString(): string
    {
        $seconds = $this->seconds;

        $minutes = 0;
        $hours = 0;
        $days = 0;
        $weeks = 0;

        if ($seconds >= 60) {
            $minutes = (int)($seconds / 60);
            $seconds = $seconds % 60;
        }

        if ($minutes >= 60) {
            $hours = (int)($minutes / 60);
            $minutes = $minutes % 60;
        }

        if ($hours >= 24) {
            $days = (int)($hours / 24);
            $hours = $hours % 24;
        }

        if ($days >= 7) {
            $weeks = (int)($days / 7);
            $days = $days % 7;
        }

        $retVal = ($weeks) ? sprintf(Duration::FORMAT, $weeks, Duration::UNIT_WEEKS) : Duration::SPACE;
        $retVal .= (($weeks || $days)) ? sprintf(Duration::FORMAT, $days, Duration::UNIT_DAYS) : Duration::SPACE;
        $retVal .= ($days || $hours) ? sprintf(Duration::FORMAT, $hours, Duration::UNIT_HOURS) : Duration::SPACE;
        $retVal .= ($hours || $minutes) ? sprintf(Duration::FORMAT, $minutes, Duration::UNIT_MINUTES) : Duration::SPACE;
        $retVal .= sprintf(Duration::FORMAT, $seconds, Duration::UNIT_SECONDS);

        return trim($retVal);
    }
}

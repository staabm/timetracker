<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTracker\Model;

class Duration
{

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

        $retVal = ($weeks) ? sprintf('%02dw ', $weeks) : '    ';
        $retVal .= (($weeks || $days)) ? sprintf('%02dd ', $days) : '    ';
        $retVal .= ($days || $hours) ? sprintf('%02dh ', $hours) : '    ';
        $retVal .= ($hours || $minutes) ? sprintf('%02dm ', $minutes) : '    ';
        $retVal .= sprintf('%02ds', $seconds);

        return $retVal;
    }
}

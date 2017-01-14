<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTracker;

use DateTime;
use DateTimeInterface;
use Stahlstift\TimeTracker\Output\Console;
use Stahlstift\TimeTracker\Output\TableRow;

class TimeTracker
{
    /**
     * @var Parser
     */
    private $parser = null;
    /**
     * @var Console
     */
    private $console = null;

    /**
     * @param Parser $parser
     * @param Console $console
     */
    public function __construct(Parser $parser, Console $console)
    {
        $this->parser = $parser;
        $this->console = $console;
    }

    /**
     * @param string $headline
     * @param TableRow[] $rows
     */
    private function printResult(string $headline, array $rows)
    {
        $this->console->nextLine();
        $this->console->printText($headline);
        $this->console->nextLine();
        $this->console->printTable($rows);
        $this->console->nextLine();
    }

    /**
     * @param string $headline
     * @param int $cols
     * @param int $year
     * @param int $month
     * @param string $username
     * @param string $ticket
     */
    private function show(
        string $headline,
        int $cols,
        int $year = 0,
        int $month = 0,
        string $username = '',
        string $ticket = ''
    ) {
        $regex = '';

        if ($year) {
            if ($month) {
                $regex = $year . '-' . sprintf('%02d', $month) . '-\d{1,2}';
                $date = DateTime::createFromFormat('!m', (string)$month);
                $monthName = $date->format('F');
                $headline = sprintf($headline, $monthName, $year);
            } else {
                $regex = $year . '-\d{1,2}-\d{1,2}';
                $headline = sprintf($headline, $year);
            }
        }

        if ($cols == 2) {
            $this->showTwoColumnUserDataPerRegex($headline, $regex, $username, $ticket);
        } elseif ($cols == 3) {
            $this->showThreeColumnUserDataPerRegex($headline, $regex, $username, $ticket);
        }
    }

    /**
     * @param string $headline
     * @param string $regexForDate
     * @param string $username
     * @param string $ticket
     */
    private function showTwoColumnUserDataPerRegex(
        string $headline,
        string $regexForDate = '',
        string $username = '',
        string $ticket = ''
    ) {
        $data = [];
        foreach ($this->parser->filter($username, $ticket, $regexForDate) as $line) {
            list($dateString, $ticket, $user, $duration, $id) = explode(',', $line);
            if (!isset($data[$user])) {
                $data[$user] = 0;
            }
            $data[$user] += $duration;
        }

        ksort($data);

        // todo implement sort
        // krsort($data);
        // asort($data);
        // arsort($data);

        $rows = [];
        $rows[] = new TableRow(true, 'Username', 'Time');;

        foreach ($data as $user => $seconds) {
            $duration = new Duration($seconds);
            $rows[] = new TableRow(false, $user, $duration->getTimeString());
        }

        $this->printResult($headline, $rows);
    }

    /**
     * @param string $headline
     * @param string $regexForDate
     * @param string $username
     * @param string $ticket
     */
    private function showThreeColumnUserDataPerRegex(
        string $headline,
        string $regexForDate = '',
        string $username = '',
        string $ticket = ''
    ) {
        $data = [];
        foreach ($this->parser->filter($username, $ticket, $regexForDate) as $line) {
            list($dateString, $ticket, $user, $duration, $id) = explode(',', $line);
            if (!isset($data[$user][$ticket])) {
                $data[$user][$ticket] = 0;
            }
            $data[$user][$ticket] += $duration;
        }

        // todo implement sort
        ksort($data);

        $rows = [];
        $rows[] = new TableRow(true, 'Username', 'Ticket', 'Time');;

        foreach ($data as $user => $tmp) {
            $rows[] = new TableRow(false, $user, '', '');

            foreach ($tmp as $ticket => $seconds) {
                $duration = new Duration($seconds);
                $rows[] = new TableRow(false, '', $ticket, $duration->getTimeString());;
            }
        }

        $this->printResult($headline, $rows);
    }

    /**
     * @param int $year
     * @param int $month
     */
    public function showOverviewPerUser(int $year = 0, int $month = 0)
    {
        if ($year) {
            $headline = "Overview for %d";
            if ($month) {
                $headline = "Overview for %s in %d";
            }
        } else {
            $headline = "Overview";
        }
        $this->show($headline, 2, $year, $month);
    }

    /**
     * @param int $year
     * @param int $month
     */
    public function showOverviewPerUserAndTicket(int $year = 0, int $month = 0)
    {
        if ($year) {
            $headline = "Overview for %d";
            if ($month) {
                $headline = "Overview for %s in %d";
            }
        } else {
            $headline = "Overview";
        }
        $this->show($headline, 3, $year, $month);
    }

    /**
     * @param string $username
     * @param int $year
     * @param int $month
     */
    public function showTotalForUser(string $username, int $year = 0, int $month = 0)
    {
        if ($year) {
            $headline = "Total for '$username' in %d";
            if ($month) {
                $headline = "Total for '$username' in %s in %d";
            }
        } else {
            $headline = "Total for '$username'";
        }
        $this->show($headline, 2, $year, $month, $username);
    }

    /**
     * @param string $username
     * @param int $year
     * @param int $month
     */
    public function showOverviewForUserPerTicket(string $username, int $year = 0, int $month = 0)
    {
        if ($year) {
            $headline = "Overview for '$username' in %d";
            if ($month) {
                $headline = "Overview for '$username' in %s in %d";
            }
        } else {
            $headline = "Overview for '$username'";
        }
        $this->show($headline, 3, $year, $month, $username);
    }

    /**
     * @param string $user
     * @param string $ticket
     * @param int $duration
     * @param DateTimeInterface $date
     */
    public function track(string $user, string $ticket, int $duration, DateTimeInterface $date)
    {
        $this->parser->track($user, $ticket, $duration, $date);
    }

}
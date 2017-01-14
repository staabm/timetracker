<?php
declare(strict_types = 1);

use Stahlstift\TimeTracker\Parser;
use Stahlstift\TimeTracker\Renderer\Console;
use Stahlstift\TimeTracker\TimeTracker;

$action = (isset($argv[1])) ? $argv[1] : 'help';

$parser = new Parser(__DIR__ . '/../timetracker.csv');
$timeTracker = new TimeTracker($parser, new Console());

const HELP = 'help';
const USER_OVERVIEW = 'useroverview';
const USER_AND_TICKET_OVERVIEW = 'userticketoverview';
const USER_TOTAL = 'usertotal';
const USER_DETAILS = 'userdetails';

switch ($action) {
    default:
    case HELP:
        echo "Usage: ./vendor/bin/track stats ..." . PHP_EOL;
        echo "[optional]" . PHP_EOL;
        echo "\t" . HELP . "\t\t\t\t\tshow this help" . PHP_EOL;
        echo "\t" . USER_OVERVIEW . " [year] [month]\t\tUsersoverview with total time" . PHP_EOL;
        echo "\t" . USER_AND_TICKET_OVERVIEW . " [year] [month]\tUser overview with total time per ticket" . PHP_EOL;
        echo "\t" . USER_TOTAL . " username [year] [month]\tUser total time" . PHP_EOL;
        echo "\t" . USER_DETAILS . " username [year] [month]\tUser total time per Ticket" . PHP_EOL;
        break;
    case USER_OVERVIEW:
        if (isset($argv[2])) {
            $validateYear($argv[2]);
            $year = $argv[2];
        } else {
            $year = 0;
        }

        if (isset($argv[3])) {
            $validateMonth($argv[3]);
            $month = $argv[3];
        } else {
            $month = 0;
        }

        $timeTracker->showOverviewPerUser((int)$year, (int)$month);
        break;
    case USER_AND_TICKET_OVERVIEW:
        if (isset($argv[2])) {
            $validateYear($argv[2]);
            $year = $argv[2];
        } else {
            $year = 0;
        }

        if (isset($argv[3])) {
            $validateMonth($argv[3]);
            $month = $argv[3];
        } else {
            $month = 0;
        }

        $timeTracker->showOverviewPerUserAndTicket((int)$year, (int)$month);
        break;
    case USER_TOTAL:
        $user = (isset($argv[2])) ? $argv[2] : '';

        $validateUser($user);

        if (isset($argv[3])) {
            $validateYear($argv[3]);
            $year = $argv[3];
        } else {
            $year = 0;
        }

        if (isset($argv[4])) {
            $validateMonth($argv[4]);
            $month = $argv[4];
        } else {
            $month = 0;
        }

        $timeTracker->showTotalForUser($user, (int)$year, (int)$month);
        break;
    case USER_DETAILS:
        $user = (isset($argv[2])) ? $argv[2] : '';

        $validateUser($user);

        if (isset($argv[3])) {
            $validateYear($argv[3]);
            $year = $argv[3];
        } else {
            $year = 0;
        }

        if (isset($argv[4])) {
            $validateMonth($argv[4]);
            $month = $argv[4];
        } else {
            $month = 0;
        }

        $timeTracker->showOverviewForUserPerTicket($user, (int)$year, (int)$month);
        break;
}

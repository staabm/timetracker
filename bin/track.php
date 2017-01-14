<?php
declare(strict_types = 1);

use Stahlstift\TimeTracker\Validation;

include_once __DIR__ . '/../vendor/autoload.php';

// enforce UTC
date_default_timezone_set('UTC');

if (count($argv) <= 1) {
    echo "Usage: ./vendor/bin/track track username [ticket]" . PHP_EOL;
    echo "Usage: ./vendor/bin/track stats help" . PHP_EOL;
    exit();
}

$validateUser = function ($user) {
    if (empty($user)) {
        echo "parameter 'username' is needed" . PHP_EOL;
        exit();
    } elseif (preg_match(Validation::USERNAME, $user) == false) {
        echo "parameter 'username' must be in format '" . Validation::USERNAME . "'" . PHP_EOL;
        exit();
    }
};

$validateTicket = function ($ticket) {
    if (preg_match(Validation::TICKET, $ticket) == false) {
        echo "parameter 'ticket' must be in format '" . Validation::TICKET . "'" . PHP_EOL;
        exit();
    }
};

$validateYear = function ($year) {
    if (preg_match(Validation::YEAR, $year) == false) {
        echo "parameter 'year' must be in format '" . Validation::YEAR . "'" . PHP_EOL;
        exit();
    }
};

$validateMonth = function ($month) {
    $month = (int)$month;
    if ($month <= 0 || $month > 12) {
        echo "parameter 'month' must be >0 and <13" . PHP_EOL;
        exit();
    }
};

$argv = array_splice($argv, 1);

if ($argv[0] == 'stats') {
    include_once __DIR__ . '/stats.php';
} elseif ($argv[0] == 'time') {
    include_once __DIR__ . '/tracker.php';
}

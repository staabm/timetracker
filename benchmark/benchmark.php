<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTracker;

use Stahlstift\TimeTracker\Renderer\Console;

include_once __DIR__ . '/../vendor/autoload.php';

// enforce UTC
date_default_timezone_set('UTC');

$runs = 100;

$file = __DIR__ . '/mockdata.csv';
$timeTracker = new TimeTracker(new Parser($file), new Console());

$results = [];

for ($i = 0; $i < $runs; $i++) {
    ob_start();

    $start = microtime(true);
    $timeTracker->showOverviewPerUserAndTicket();
    $results[] = microtime(true) - $start;

    ob_end_clean();

    echo '.';
}

echo "Runs: $runs Average: " . (int)(array_sum($results) / $runs) . "s" . PHP_EOL;

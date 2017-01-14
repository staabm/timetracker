<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTracker;

use DateTimeImmutable;

include_once __DIR__ . '/../vendor/autoload.php';

// enforce UTC
date_default_timezone_set('UTC');

$parser = new Parser(__DIR__ . '/../timetracker.csv');

$userbase = ['ml', 'peter', 'markus', 'wilhelm', 'very_long_name'];
foreach (range(1, 10000) as $i) {
    $year = mt_rand(2014, 2016);
    $month = mt_rand(1, 12);
    $day = mt_rand(1, 31);

    $user = $userbase[array_rand($userbase)];
    $ticket = '#' . mt_rand(1, 100);

    $parser->track($user, $ticket, mt_rand(60 * 15, 60 * 60), new DateTimeImmutable("$year-$month-$day"));
}

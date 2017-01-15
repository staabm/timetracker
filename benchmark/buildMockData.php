<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTracker;

use DateTimeImmutable;
use Stahlstift\TimeTracker\Utils\FileSystem;
use Stahlstift\TimeTracker\Utils\GeneratorCollection;

include_once __DIR__ . '/../vendor/autoload.php';

// enforce UTC
date_default_timezone_set('UTC');

$parser = new Parser(
    new FileSystem(),
    __DIR__ . '/mockdata.csv',
    new GeneratorCollection()
);

//$entries = 1000000;
//$entries = 500000;
//$entries = 100000;
$entries = 10000;

$userbase = ['odin', 'thor', 'tyr', 'loki', 'heimdall'];
for ($i = 0; $i < $entries; $i++) {
    $year = mt_rand(2014, 2016);
    $month = mt_rand(1, 12);
    $day = mt_rand(1, 31);

    $user = $userbase[array_rand($userbase)];
    $ticket = '#' . mt_rand(1, 100);

    $min = 60 * 15; // 15 Minutes
    $max = 60 * 60; // 1 Hour

    $parser->track($user, $ticket, mt_rand($min, $max), new DateTimeImmutable("$year-$month-$day"));
}

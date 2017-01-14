<?php
declare(strict_types = 1);

use Stahlstift\TimeTracker\Model\Duration;
use Stahlstift\TimeTracker\Parser;
use Stahlstift\TimeTracker\Renderer\Console;
use Stahlstift\TimeTracker\TimeTracker;

$user = (isset($argv[1]) ? $argv[1] : '');
$ticket = (isset($argv[2]) ? $argv[2] : 'none');

$validateUser($user);
$validateTicket($ticket);

$parser = new Parser(__DIR__ . '/../timetracker.csv');
$tracker = new TimeTracker($parser, new Console());

$startDuration = microtime(true);
$dotCounter = 0;
$totalCounter = 0;

$shutdownDispatched = false;
$shutdown = function () use (
    $tracker,
    $user,
    $ticket,
    $startDuration,
    &$dotCounter,
    &$totalCounter,
    &
    $shutdownDispatched
) {
    if ($shutdownDispatched) {
        return;
    }

    $duration = new Duration($totalCounter);
    echo 'Total: ' . $duration->getTimeString() . PHP_EOL;

    $shutdownDispatched = true;

    $date = new DateTimeImmutable();

    $duration = (int)(microtime(true) - $startDuration);
    $tracker->track($user, $ticket, $duration, $date);
    exit();
};

register_shutdown_function($shutdown);
pcntl_signal(SIGINT, $shutdown);
pcntl_signal(SIGTERM, $shutdown);

$lastTick = $startDuration;

echo "Tracking started for '$user' with ticket '$ticket'" . PHP_EOL;
while (true) {
    pcntl_signal_dispatch();

    $totalCounter++;

    $tmp = microtime(true) - $lastTick;
    if ($tmp > 60) {
        $lastTick = microtime(true);
        $dotCounter++;

        echo ".";

        switch ($dotCounter) {
            case 15:
            case 30:
            case 45:
                echo " $dotCounter ";
                break;
            case 60:
                echo " $dotCounter " . PHP_EOL;
                $dotCounter = 0;
                break;
        }
    }

    sleep(1);
}

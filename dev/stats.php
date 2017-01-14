<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTracker;

use Stahlstift\TimeTracker\Output\Console;

include_once __DIR__ . '/../vendor/autoload.php';

// enforce UTC
date_default_timezone_set('UTC');

$parser = new Parser(__DIR__ . '/../timetracker.csv');
$timeTracker = new TimeTracker($parser, new Console());

$timeTracker->showOverviewPerUser();
$timeTracker->showOverviewPerUser(2016);
$timeTracker->showOverviewPerUser(2016, 12);

$timeTracker->showOverviewPerUserAndTicket();
$timeTracker->showOverviewPerUserAndTicket(2016);
$timeTracker->showOverviewPerUserAndTicket(2016, 12);

$timeTracker->showTotalForUser('markus');
$timeTracker->showTotalForUser('markus', 2016);
$timeTracker->showTotalForUser('markus', 2016, 12);

$timeTracker->showOverviewForUserPerTicket('markus');
$timeTracker->showOverviewForUserPerTicket('markus', 2016);
$timeTracker->showOverviewForUserPerTicket('markus', 2016, 12);

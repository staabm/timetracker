```
  ~~~~~~~~~~~~~   _______ _             _______             _             
 ( .'11 12 1'. )  |__   __(_)           |__   __|           | |
 | :10 \    2: |     | |   _ _ __ ___   ___| |_ __ __ _  ___| | _____ _ __
 | :9   @-> 3: |     | |  | | '_ ` _ \ / _ \ | '__/ _` |/ __| |/ / _ \ '__|
 | :8       4; |     | |  | | | | | | |  __/ | | | (_| | (__|   <  __/ |
 | '..7 6 5..' |     |_|  |_|_| |_| |_|\___|_|_|  \__,_|\___|_|\_\___|_|
  ~-----------~ 
```
TimeTracker is an ultra simple time tracking tool with no deps and made to live as a require-dev in your project.

[![Build Status](https://travis-ci.org/stahlstift/timetracker.svg?branch=master)](https://travis-ci.org/stahlstift/timetracker)
[![Coverage Status](https://coveralls.io/repos/stahlstift/timetracker/badge.svg)](https://coveralls.io/r/stahlstift/timetracker)
[![Latest Stable Version](https://poser.pugx.org/stahlstift/timetracker/version)](https://packagist.org/packages/stahlstift/timetracker)
[![Total Downloads](https://poser.pugx.org/stahlstift/timetracker/downloads)](https://packagist.org/packages/stahlstift/timetracker)
[![License](https://poser.pugx.org/stahlstift/timetracker/license)](https://packagist.org/packages/stahlstift/timetracker)

## About
For a new project I need to track my time investment. The existing tools are to heavy and/or are to mighty for my needs. I just want to be able to track my time in a fast and dev friendly way. So I came up with this solution. It can easily handle small teams, it's really fast and most important, you can commit it, because it can be merged by a vcs. 

## Usage
### Requirements
* PHP >= 7.0
* pcntl extension

### Installation
```
composer require-dev "stahlstift/timetracker"
```
Ultra-Secret-Hint: 
It's also possible to install it globally and use TimeTracker in every project - even non composer or php projects.  
```
composer global require "stahlstift/timetracker"
```
Caution: The command will then be just "track" and not "./vendor/bin/track" 

### Time tracking
```
./vendor/bin/track time username [ticket/project/whatever]

Example:

./vendor/bin/track time stahlstift tracker_unittest
Tracking started for 'stahlstift' with ticket 'tracker_unittest'
............... 15 ............... 15 ............... 15 ............... 60
........

Press ctrl + c when done to write tracking

^CTotal:         01h 08m 23s

```

### Stats
```
To see all available commans use:
./vendor/bin/track stats help

Examples:

Overview for December in 2016
╔════════════════╦═════════════════════╗
║ Username       ║ Time                ║
╠════════════════╬═════════════════════╣
║ markus         ║     01d 36h 33m 06s ║
║ peter          ║     01d 36h 49m 13s ║
║ very_long_name ║     01d 38h 58m 39s ║
║ wilhelm        ║     01d 40h 14m 59s ║
╚════════════════╩═════════════════════╝

Total for 'markus' in 2016
╔══════════╦═════════════════════╗
║ Username ║ Time                ║
╠══════════╬═════════════════════╣
║ markus   ║ 02w 02d 46h 34m 50s ║
╚══════════╩═════════════════════╝
```

### How to add manual entries?
Well, it's a csv - open the file and add a new line.   
Warning: Use "\n" as LF!

### How to delete an entry?
Well, I think you can guess it now...

### CSV Format

```
{d-m-y},{ticket},{username},{duration_in_seconds},id_{random_int}
2014-07-07,write_readme,stahlstift,2053,id_1588960344
```

## Benchmark / Performance
### How?
I created a mock database with random entries between 2014 and 2016 for 5 different users between 15 mins and 60 mins. The benchmark was running on a Macbook Air (late 2010 - Core2Duo 1.4 ghz) with php 7.1.0 and xdebug enabled.   

I benchmarked the most complex view in TimeTracker with the Console renderer and print out the average time needed to render.

### Results

Even with 1 000 000 entries in the csv file - it's still usable with 25 seconds on a slow device. Thx to the streams and generators!

| Entries   | Runs  |  Avg / Run |
|----------:|------:|-----------:|
| 1 000 000 |   10  |  25s       |
|   500 000 |   10  |  20s       |
|   100 000 |   10  |   2s       |
|    10 000 |  100  |  <0s       |


### Run yourself
```
#create mockdata (takes some time)
# (optionally) open the file and modify the values
php benchmark/buildMockData.php

#run benchmark
# (optionally) open the file and modify the values
php benchmark/benchmark.php
```

## Todos before release
* global installation support (check for the usage strings in stats.php and track.php and build it dynamically)
* Make installable and usable with composer
* UnitTests

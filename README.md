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

## About
For a new project I need to track my time investment. The existing tools are to heavy and/or to mighty for my needs.     
I just want to be able to track my time in a fast and developer friendly way. So I came up with this solution.    
It can easily handle small teams, it's really fast and most important, you can commit it, because it can be merged by a vcs. 

## Usage
### Requirements
you need PHP >= 7.0 and the "pcntl" extension enabled

### Installation
```
composer require-dev stahlstift/timetracker
```

### Time tracking
```
vendor/bin/track.php username [ticket/project/whatever]
```

```
./vendor/bin/track stahlstift tracker_unittest
Tracking started for 'stahlstift' with ticket 'tracker_unittest'
............... 15 ............... 15 ............... 15 ............... 60
........

Press ctrl + c when done to write tracking

^CTotal:         01h 08m 23s

```

### Stats
```
implemented but currently not usable per cli

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
Well, it's a csv file - open the file and add it.   
Warning: Use "\n" as LF!

### CSV Format

```
{d-m-y},{ticket},{username},{duration_in_seconds},id_{random_int}
2014-07-07,write_readme,stahlstift,2053,id_1588960344
```

### Todo
* Performance test (see dev/createmockdata.php and dev/stats.php)
* Make installable and usable with composer
* Refactor CLI argument handling
* make stats usable from CLI
* Better readme
* UnitTests
* ~~Add typcial code quality tools (phpcs, phpmd, ...)~~
* Add travis CI
* Final cleanup and refactoring
* Start implementing new features 
  * Stats: support sorting options
  * Stats: support of exporting reports to html 
  * ...

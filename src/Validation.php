<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTracker;

class Validation
{
    const USERNAME = '/^[a-zA-Z0-9_.]{1,32}/';
    const TICKET = '/^[a-zA-Z0-9_.#]{1,32}/';
    const YEAR = '/\d+/';
}

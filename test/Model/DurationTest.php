<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTrackerTest\Model;

use PHPUnit\Framework\TestCase;
use Stahlstift\TimeTracker\Model\Duration;

/**
 * @covers \Stahlstift\TimeTracker\Model\Duration
 */
class DurationTest extends TestCase
{
    /**
     * @group Integration
     */
    public function testGetFullTimeStringOutput()
    {
        $duration = new Duration(717848);
        $this->assertSame("01w 01d 07h 24m 08s", $duration->getTimeString());
    }

}

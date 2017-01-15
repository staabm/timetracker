<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTrackerTest\Model;

use PHPUnit\Framework\TestCase;
use Stahlstift\TimeTracker\Model\TableRow;

/**
 * @covers \Stahlstift\TimeTracker\Model\TableRow
 */
class TableRowTest extends TestCase
{
    /**
     * @group Integration
     */
    public function testGetter()
    {
        $tableRow = new TableRow(true, "column1", "column2", "column3");

        $this->assertSame(3, $tableRow->getColumnsCount());
        $this->assertSame(["column1", "column2", "column3"], $tableRow->getColumns());
        $this->assertTrue($tableRow->isHead());
    }

}

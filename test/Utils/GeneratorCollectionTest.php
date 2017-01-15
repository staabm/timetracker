<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTrackerTest\Utils;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;
use PHPUnit\Framework\TestCase;
use Stahlstift\TimeTracker\Utils\GeneratorCollection;

/**
 * @covers \Stahlstift\TimeTracker\Utils\GeneratorCollection
 */
class GeneratorCollectionTest extends TestCase
{

    public function testReadLineFromFile()
    {
        $lines = ["line1", "line2", "line3"];

        $root = vfsStream::setup('root', 000);
        $file = new vfsStreamFile('unittest.file');
        $file->setContent(implode("\n", $lines));
        $root->addChild($file);

        $helper = new GeneratorCollection();

        $lineCounter = 0;
        foreach ($helper->readLinesFromFile($file->url()) as $value) {
            $this->assertSame($lines[$lineCounter], $value);
            $lineCounter++;
        }
    }

    public function testFilterRegex()
    {
        $helper = new GeneratorCollection();

        $hits = 0;

        $data = ['matchnot', '1234', '1', 'matchnot'];
        foreach ($helper->filterWithRegex($data, '/\d+/') as $value) {
            $this->assertTrue(in_array($value, ['1234', '1']));
            $hits++;
        }

        $this->assertSame(2, $hits);
    }

}

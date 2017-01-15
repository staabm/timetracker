<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTrackerTest\Utils;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\visitor\vfsStreamStructureVisitor;
use PHPUnit\Framework\TestCase;
use Stahlstift\TimeTracker\Exception\Exception;
use Stahlstift\TimeTracker\Utils\FileSystem;

/**
 * @covers \Stahlstift\TimeTracker\Utils\FileSystem
 */
class FileSystemTest extends TestCase
{

    /**
     * @expectedException Exception
     * @expectedExceptionMessage TimeTracker: Can't create directory ('vfs://root/subfolder')
     */
    public function testCreatePathThrowsExceptionWhenDirCantCreated()
    {
        $root = vfsStream::setup('root', 000);
        $filesystem = new FileSystem();
        $filesystem->createPath($root->url() . '/subfolder/timetracker.csv');
    }

    public function testCreatePath()
    {
        vfsStream::setQuota(0);
        $root = vfsStream::setup('root');
        $filesystem = new FileSystem();
        $filesystem->createPath($root->url() . '/subfolder/timetracker.csv');
        /** @var vfsStreamStructureVisitor $inspection */
        $inspection = vfsStream::inspect(new vfsStreamStructureVisitor());

        $this->assertEquals(
            [
                'root' => [
                    'subfolder' => [
                        'timetracker.csv' => null
                    ]
                ]
            ],
            $inspection->getStructure()
        );
    }

}

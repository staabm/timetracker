<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTracker\Utils;

use Stahlstift\TimeTracker\Exception\Exception;

class FileSystem
{

    /**
     * @param string $path
     *
     * @throws Exception
     */
    public function createPath(string $path)
    {
        $dir = pathinfo($path, PATHINFO_DIRNAME);
        if (!is_dir($dir)) {
            if (!@mkdir($dir, 0777, true)) {
                throw new Exception("TimeTracker: Can't create directory ('$dir')");
            }
        }

        if (!is_file($path)) {
            touch($path);
        }
    }

}

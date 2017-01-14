<?php
declare(strict_types = 1);

namespace Stahlstift\TimeTracker\Renderer;

use Stahlstift\TimeTracker\Model\TableRow;

interface Renderer
{
    /**
     * @param string $title
     * @param TableRow[] $rows
     */
    public function renderResult(string $title, array $rows);

}

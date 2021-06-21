<?php
declare(strict_types=1);

namespace App\Item\Strategy\Factory;

use App\Item\Item;
use App\Item\Strategy\UpdateItem;

interface StrategyFactory
{
    public function createFor(Item $item): UpdateItem;
}

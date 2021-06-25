<?php
declare(strict_types=1);

namespace App\Item\Strategy;

use App\Item\Item;

interface UpdateItem
{
    public function next(UpdateItem $strategy): UpdateItem;

    public function update(Item $item): ?UpdateItem;
}

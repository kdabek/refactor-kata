<?php

declare(strict_types=1);

namespace App\Item\Strategy;

use App\Item\Item;

class DecreaseSellIn extends BaseStrategy
{
    public function update(Item $item): ?UpdateItem
    {
        $item->decreaseSellIn();

        return parent::update($item);
    }
}

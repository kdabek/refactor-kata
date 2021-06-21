<?php
declare(strict_types=1);

namespace App\Item\Strategy;

use App\Item\Item;

class DropQuality extends BaseStrategy
{
    public function update(Item $item): ?UpdateItem
    {
        $item->updateQuality($item->getQuality()->drop());

        return parent::update($item);
    }
}

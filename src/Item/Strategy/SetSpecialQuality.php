<?php

declare(strict_types=1);

namespace App\Item\Strategy;

use App\Item\{Item, Quality};

class SetSpecialQuality extends BaseStrategy
{
    public function update(Item $item): ?UpdateItem
    {
        $item->updateQuality(Quality::fromInteger(Quality::SPECIAL_QUALITY));

        return parent::update($item);
    }
}

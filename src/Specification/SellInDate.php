<?php
declare(strict_types=1);

namespace App\Specification;

use App\Item\Item;
use App\Item\SellIn;

class SellInDate extends Composite\CompositeSpecification
{
    public function isSatisfiedBy(Item $item): bool
    {
        if ($item->getSellIn()->greaterThan(SellIn::fromInteger(0))) {
            return true;
        }

        return false;
    }
}

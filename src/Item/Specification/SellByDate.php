<?php
declare(strict_types=1);

namespace App\Item\Specification;

use App\Item\{Item, SellIn};

class SellByDate extends Composite\CompositeSpecification
{
    public function isSatisfiedBy(Item $item): bool
    {
        if ($item->getSellIn()->lessThanOrEqual(SellIn::fromInteger(0))) {
            return true;
        }

        return false;
    }
}

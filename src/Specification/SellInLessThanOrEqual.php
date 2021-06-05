<?php
declare(strict_types=1);

namespace App\Specification;

use App\Item\Item;
use App\Item\SellIn;

class SellInLessThanOrEqual extends Composite\CompositeSpecification
{
    /**
     * @var SellIn
     */
    private $sellIn;

    public function __construct(int $sellIn)
    {
        $this->sellIn = SellIn::fromInteger($sellIn);
    }

    public function isSatisfiedBy(Item $item): bool
    {
        return $item->getSellIn()->lessThanOrEqual($this->sellIn);
    }
}

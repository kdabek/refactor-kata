<?php

declare(strict_types=1);

namespace App\Item\Specification\Composite;

use App\Item\Item;

interface SpecificationInterface
{
    public function isSatisfiedBy(Item $item): bool;
}

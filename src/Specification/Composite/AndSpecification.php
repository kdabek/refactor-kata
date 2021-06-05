<?php
declare(strict_types=1);

namespace App\Specification\Composite;

use App\Item\Item;

class AndSpecification extends CompositeSpecification
{
    /**
     * @var array
     */
    private $specifications;

    /**
     * @param array $specifications
     */
    public function __construct(SpecificationInterface ...$specifications)
    {
        $this->specifications = $specifications;
    }

    public function isSatisfiedBy(Item $item): bool
    {
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($item)) {
                return false;
            }
        }

        return true;
    }
}

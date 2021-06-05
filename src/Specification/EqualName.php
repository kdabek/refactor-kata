<?php
declare(strict_types=1);

namespace App\Specification;

use App\Item\Item;

class EqualName extends Composite\CompositeSpecification
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function isSatisfiedBy(Item $item): bool
    {
        return $this->name === $item->getName();
    }
}

<?php
declare(strict_types=1);

namespace App;

use App\Item\Item;
use App\Specification\Composite\SpecificationInterface;

use function call_user_func;

final class GildedRose
{
    /**
     * @var array
     */
    private $specifications;

    public function __construct(array $specifications)
    {
        $this->specifications = $specifications;
    }

    public function updateItem(Item $item)
    {
        /** @var SpecificationInterface $specification */
        foreach ($this->specifications as [$specification, $callback]) {
            if ($specification->isSatisfiedBy($item)) {
                call_user_func($callback, $item);
                break;
            }
        }
    }
}

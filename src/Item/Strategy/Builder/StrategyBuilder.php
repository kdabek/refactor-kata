<?php
declare(strict_types=1);

namespace App\Item\Strategy\Builder;

use App\Item\Specification\Composite\SpecificationInterface;
use App\Item\Strategy\UpdateItem;
use LogicException;
use function array_map;
use function array_reduce;
use function array_shift;
use function count;

class StrategyBuilder
{
    /**
     * @var array
     */
    private $specifications = [];

    /**
     * @var array
     */
    private $strategies = [];

    public function when(SpecificationInterface $specification): self
    {
        $this->specifications[] = $specification;

        return $this;
    }

    public function then(UpdateItem ...$strategies): self
    {
        $first = array_shift($strategies);

        array_reduce($strategies, function (UpdateItem $current, UpdateItem $next) {
            $current->next($next);

            return $next;
        }, $first);

        $this->strategies[] = $first;

        return $this;
    }

    public function build(): array
    {
        if (count($this->specifications) !== count($this->strategies)) {
            throw new LogicException('Incorrect specifications and strategies count.');
        }

        return array_map(function (SpecificationInterface $specification, UpdateItem $strategy) {
            return [$specification, $strategy];
        }, $this->specifications, $this->strategies);
    }
}

<?php
declare(strict_types=1);

namespace App\Item\Builder;

use LogicException;
use App\Item\Specification\Composite\SpecificationInterface;

use function count;

class BehaviorBuilder
{
    /**
     * @var array
     */
    private $specifications = [];

    /**
     * @var array
     */
    private $callbacks = [];

    public function when(SpecificationInterface $specification): self
    {
        $this->specifications[] = $specification;

        return $this;
    }

    public function then(callable $callback): self
    {
        $this->callbacks[] = $callback;

        return $this;
    }

    public function build(): array
    {
        if (count($this->specifications) !== count($this->callbacks)){
            throw new LogicException('Incorrect specifications and callbacks count.');
        }

        return array_map(function (SpecificationInterface $specification, callable $callback) {
            return [$specification, $callback];
        }, $this->specifications, $this->callbacks);
    }
}

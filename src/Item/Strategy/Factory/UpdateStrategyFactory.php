<?php

declare(strict_types=1);

namespace App\Item\Strategy\Factory;

use App\Item\Item;
use App\Item\Strategy\Builder\StrategyBuilder;
use App\Item\Strategy\UpdateItem;
use LogicException;

class UpdateStrategyFactory implements StrategyFactory
{
    /**
     * @var StrategyBuilder
     */
    private $builder;

    /**
     * @var array
     */
    private $strategies = [];

    /**
     * @var bool
     */
    private $initialized = false;

    public function __construct(StrategyBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @param Item $item
     * @return UpdateItem
     * @throws LogicException
     */
    public function createFor(Item $item): UpdateItem
    {
        if (!$this->initialized) {
            $this->strategies  = $this->builder->build();
            $this->initialized = true;
        }

        foreach ($this->strategies as [$specification, $strategy]) {
            if ($specification->isSatisfiedBy($item)) {
                return $strategy;
            }
        }

        throw new LogicException('Strategy not found');
    }
}

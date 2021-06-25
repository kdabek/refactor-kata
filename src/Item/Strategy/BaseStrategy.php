<?php

declare(strict_types=1);

namespace App\Item\Strategy;

use App\Item\Item;

abstract class BaseStrategy implements UpdateItem
{
    /**
     * @var UpdateItem
     */
    private $nextStrategy;

    public function next(UpdateItem $strategy): UpdateItem
    {
        $this->nextStrategy = $strategy;

        return $strategy;
    }

    public function update(Item $item): ?UpdateItem
    {
        if ($this->nextStrategy) {
            return $this->nextStrategy->update($item);
        }

        return null;
    }
}

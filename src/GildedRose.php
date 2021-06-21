<?php
declare(strict_types=1);

namespace App;

use App\Item\Strategy\Factory\StrategyFactory;
use App\Item\Item;

final class GildedRose
{
    /**
     * @var StrategyFactory
     */
    private $strategyFactory;

    public function __construct(StrategyFactory $strategyFactory)
    {
        $this->strategyFactory = $strategyFactory;
    }

    public function updateItem(Item $item)
    {
        $strategy = $this->strategyFactory->createFor($item);
        $strategy->update($item);
    }
}

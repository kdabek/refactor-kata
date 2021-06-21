<?php
declare(strict_types=1);

namespace App\Item\Strategy;

use App\Item\Item;

class IncreaseQualityBy extends BaseStrategy
{
    /**
     * @var int
     */
    private $increaseBy;

    public function __construct(int $increaseBy)
    {
        $this->increaseBy = $increaseBy;
    }

    public function update(Item $item): ?UpdateItem
    {
        $item->updateQuality($item->getQuality()->increaseBy($this->increaseBy));

        return parent::update($item);
    }
}

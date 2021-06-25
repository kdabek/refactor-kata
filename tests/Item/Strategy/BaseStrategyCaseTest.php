<?php

declare(strict_types=1);

namespace App\Item\Strategy;

use App\Item\Item;
use PHPUnit\Framework\TestCase;

abstract class BaseStrategyCaseTest extends TestCase
{
    /**
     * @var UpdateItem
     */
    protected $strategy;

    /**
     * @var Item
     */
    protected $item;

    protected function setUp(): void
    {
        parent::setUp();

        $this->item = new Item('Brie', 10, 10);
    }


}

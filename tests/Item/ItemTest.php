<?php
declare(strict_types=1);

namespace App\Item;

use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function testCreate(): Item
    {
        $item = new Item('Sulfuras', 10, 10);
        $this->assertInstanceOf(Item::class, $item);

        return $item;
    }

    /**
     * @param Item $item
     *
     * @depends clone testCreate
     */
    public function testGetters(Item $item)
    {
        $this->assertEquals('Sulfuras', $item->getName());
        $this->assertEquals(10, $item->getSellIn()->getValue());
        $this->assertEquals(10, $item->getQuality()->getValue());
    }

    /**
     * @param Item $item
     *
     * @depends clone testCreate
     */
    public function testDecreaseSellIn(Item $item)
    {
        $item->decreaseSellIn();
        $this->assertEquals(9, $item->getSellIn()->getValue());
    }

    /**
     * @param Item $item
     *
     * @depends clone testCreate
     */
    public function testUpdateQuality(Item $item)
    {
        $item->updateQuality($item->getQuality()->increase());
        $this->assertEquals(11, $item->getQuality()->getValue());
    }
}

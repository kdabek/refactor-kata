<?php

declare(strict_types=1);

namespace App\Item;

use PHPUnit\Framework\TestCase;

class SellInTest extends TestCase
{
    public function testCreate(): SellIn
    {
        $sellIn = SellIn::fromInteger(1);
        $this->assertInstanceOf(SellIn::class, $sellIn);

        return $sellIn;
    }

    /**
     * @param SellIn $sellIn
     *
     * @depends clone testCreate
     */
    public function testGetter(SellIn $sellIn)
    {
        $this->assertEquals(1, $sellIn->getValue());
    }

    /**
     * @param SellIn $sellIn
     *
     * @depends clone testCreate
     */
    public function testDecrease(SellIn $sellIn)
    {
        $decreased = $sellIn->decrease();
        $this->assertEquals(0, $decreased->getValue());
    }

    /**
     * @param SellIn $sellIn
     *
     * @depends clone testCreate
     */
    public function testGreaterThan(SellIn $sellIn)
    {
        $this->assertTrue($sellIn->greaterThan(SellIn::fromInteger(0)));
    }

    /**
     * @param SellIn $sellIn
     *
     * @depends clone testCreate
     */
    public function testEqual(SellIn $sellIn)
    {
        $this->assertTrue($sellIn->lessThanOrEqual(SellIn::fromInteger(1)));
    }

    /**
     * @param SellIn $sellIn
     *
     * @depends clone testCreate
     */
    public function testLessThan(SellIn $sellIn)
    {
        $this->assertTrue($sellIn->lessThanOrEqual(SellIn::fromInteger(2)));
    }
}

<?php

declare(strict_types=1);

namespace App\Item\Specification;

use App\Item\Item;
use PHPUnit\Framework\TestCase;

class SellInLessThanOrEqualTest extends TestCase
{
    public function testSatisfiedEqual()
    {
        $name = SellInLessThanOrEqual::to(10);
        $this->assertTrue($name->isSatisfiedBy(new Item('Aged Brie', 10, 50)));
    }

    public function testSatisfiedLessThan()
    {
        $name = SellInLessThanOrEqual::to(20);
        $this->assertTrue($name->isSatisfiedBy(new Item('Aged Brie', 10, 50)));
    }

    public function testNotSatisfied()
    {
        $name = SellInLessThanOrEqual::to(5);
        $this->assertFalse($name->isSatisfiedBy(new Item('Aged Brie', 10, 50)));
    }
}

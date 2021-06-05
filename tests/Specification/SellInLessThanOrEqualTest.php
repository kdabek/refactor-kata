<?php
declare(strict_types=1);

namespace App\Specification;

use App\Item\Item;
use PHPUnit\Framework\TestCase;

class SellInLessThanOrEqualTest extends TestCase
{
    public function testSatisfiedEqual()
    {
        $name = new SellInLessThanOrEqual(10);
        $this->assertTrue($name->isSatisfiedBy(new Item('Aged Brie', 10, 50)));
    }

    public function testSatisfiedLessThan()
    {
        $name = new SellInLessThanOrEqual(20);
        $this->assertTrue($name->isSatisfiedBy(new Item('Aged Brie', 10, 50)));
    }

    public function testNotSatisfied()
    {
        $name = new SellInLessThanOrEqual(5);
        $this->assertFalse($name->isSatisfiedBy(new Item('Aged Brie', 10, 50)));
    }
}

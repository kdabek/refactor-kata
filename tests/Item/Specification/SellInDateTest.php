<?php
declare(strict_types=1);

namespace App\Item\Specification;

use App\Item\Item;
use PHPUnit\Framework\TestCase;

class SellInDateTest extends TestCase
{
    public function testSatisfied()
    {
        $name = new SellInDate();
        $this->assertTrue($name->isSatisfiedBy(new Item('Aged Brie', 10, 50)));
    }

    public function testNotSatisfied()
    {
        $name = new SellInDate();
        $this->assertFalse($name->isSatisfiedBy(new Item('Aged Brie', -10, 50)));
    }
}

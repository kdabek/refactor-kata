<?php
declare(strict_types=1);

namespace App\Specification;

use App\Item\Item;
use PHPUnit\Framework\TestCase;

class SellByDateTest extends TestCase
{
    public function testSatisfied()
    {
        $name = new SellByDate();
        $this->assertTrue($name->isSatisfiedBy(new Item('Aged Brie', -10, 50)));
    }

    public function testNotSatisfied()
    {
        $name = new SellByDate();
        $this->assertFalse($name->isSatisfiedBy(new Item('Aged Brie', 10, 50)));
    }
}

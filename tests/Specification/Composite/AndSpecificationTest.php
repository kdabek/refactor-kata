<?php
declare(strict_types=1);

namespace App\Specification\Composite;

use App\Item\Item;
use App\Specification\EqualName;
use App\Specification\SellByDate;
use App\Specification\SellInDate;
use PHPUnit\Framework\TestCase;

class AndSpecificationTest extends TestCase
{
    /**
     * @var Item
     */
    private $item;

    protected function setUp(): void
    {
        parent::setUp();

        $this->item = new Item('Aged Brie', 10, 50);
    }

    public function testAllSpecificationsSatisfied()
    {
        $name       = new EqualName('Aged Brie');
        $sellInDate = new SellInDate();

        $result = new AndSpecification($name, $sellInDate);
        $this->assertTrue($result->isSatisfiedBy($this->item));
    }

    public function testNotAllSpecificationsSatisfied()
    {
        $name       = new EqualName('Aged Brie');
        $sellByDate = new SellByDate();

        $result = new AndSpecification($name, $sellByDate);
        $this->assertFalse($result->isSatisfiedBy($this->item));
    }
}

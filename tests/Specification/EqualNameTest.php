<?php
declare(strict_types=1);

namespace App\Specification;

use App\Item\Item;
use PHPUnit\Framework\TestCase;

class EqualNameTest extends TestCase
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

    public function testSatisfied()
    {
        $name = new EqualName('Aged Brie');
        $this->assertTrue($name->isSatisfiedBy($this->item));
    }

    public function testNotSatisfied()
    {
        $name = new EqualName('Sulfuras');
        $this->assertFalse($name->isSatisfiedBy($this->item));
    }
}

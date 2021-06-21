<?php
declare(strict_types=1);

namespace App\Item\Strategy;

class DecreaseSellInTest extends BaseStrategyCaseTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->strategy = new DecreaseSellIn();
    }

    public function testUpdate()
    {
        $this->strategy->update($this->item);
        $this->assertEquals(9, $this->item->getSellIn()->getValue());
    }
}

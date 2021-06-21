<?php

namespace App\Item\Strategy;

class DecreaseQualityTest extends BaseStrategyCaseTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->strategy = new DecreaseQuality();
    }

    public function testUpdate()
    {
        $this->strategy->update($this->item);
        $this->assertEquals(9, $this->item->getQuality()->getValue());
    }
}

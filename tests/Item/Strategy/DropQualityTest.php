<?php

namespace App\Item\Strategy;

class DropQualityTest extends BaseStrategyCaseTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->strategy = new DropQuality();
    }

    public function testUpdate()
    {
        $this->strategy->update($this->item);
        $this->assertEquals(0, $this->item->getQuality()->getValue());
    }
}

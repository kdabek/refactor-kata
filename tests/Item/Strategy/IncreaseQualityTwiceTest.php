<?php

declare(strict_types=1);

namespace App\Item\Strategy;

class IncreaseQualityTwiceTest extends BaseStrategyCaseTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->strategy = new IncreaseQualityTwice();
    }

    public function testUpdate()
    {
        $this->strategy->update($this->item);
        $this->assertEquals(12, $this->item->getQuality()->getValue());
    }
}

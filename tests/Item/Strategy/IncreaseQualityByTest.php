<?php

declare(strict_types=1);

namespace App\Item\Strategy;

class IncreaseQualityByTest extends BaseStrategyCaseTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->strategy = new IncreaseQualityBy(4);
    }

    public function testUpdate()
    {
        $this->strategy->update($this->item);
        $this->assertEquals(14, $this->item->getQuality()->getValue());
    }
}

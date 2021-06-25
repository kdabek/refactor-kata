<?php

declare(strict_types=1);

namespace App\Item\Strategy;

class IncreaseQualityTest extends BaseStrategyCaseTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->strategy = new IncreaseQuality();
    }

    public function testUpdate()
    {
        $this->strategy->update($this->item);
        $this->assertEquals(11, $this->item->getQuality()->getValue());
    }
}

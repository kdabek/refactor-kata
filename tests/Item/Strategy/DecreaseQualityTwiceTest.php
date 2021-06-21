<?php
declare(strict_types=1);

namespace App\Item\Strategy;

class DecreaseQualityTwiceTest extends BaseStrategyCaseTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->strategy = new DecreaseQualityTwice();
    }

    public function testUpdate()
    {
        $this->strategy->update($this->item);
        $this->assertEquals(8, $this->item->getQuality()->getValue());
    }
}

<?php
declare(strict_types=1);

namespace App;

use App\Builder\BehaviorBuilder;
use App\Item\Item;
use App\Item\Quality;
use App\Item\SellIn;
use App\Specification\ItemName;
use App\Specification\SellByDate;
use App\Specification\SellInDate;
use App\Specification\SellInLessThanOrEqual;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    /**
     * @var array
     */
    private $behaviors;

    protected function setUp(): void
    {
        parent::setUp();

        $sulfuras   = new ItemName('Sulfuras, Hand of Ragnaros');
        $brie       = new ItemName('Aged Brie');
        $backstage  = new ItemName('Backstage passes to a TAFKAL80ETC concert');
        $sellInDate = new SellInDate();
        $sellByDate = new SellByDate();

        $this->behaviors = (new BehaviorBuilder())
            ->when($sulfuras)
            ->then(function (Item $item) {
                $item->updateQuality(Quality::fromInteger(80));
            })
            ->when($brie->and(SellInLessThanOrEqual::to(0)))
            ->then(function (Item $item) {
                $item->updateQuality($item->getQuality()->increaseTwice());
                $item->decreaseSellIn();
            })
            ->when($brie)
            ->then(function (Item $item) {
                $item->updateQuality($item->getQuality()->increase());
                $item->decreaseSellIn();
            })
            ->when($backstage->and($sellByDate))
            ->then(function (Item $item) {
                $item->updateQuality($item->getQuality()->drop());
                $item->decreaseSellIn();
            })
            ->when($backstage->and(SellInLessThanOrEqual::to(5)))
            ->then(function (Item $item) {
                $item->updateQuality($item->getQuality()->increaseBy(3));
                $item->decreaseSellIn();
            })
            ->when($backstage->and(SellInLessThanOrEqual::to(10)))
            ->then(function (Item $item) {
                $item->updateQuality($item->getQuality()->increaseTwice());
                $item->decreaseSellIn();
            })
            ->when($backstage->and($sellInDate))
            ->then(function (Item $item) {
                $item->updateQuality($item->getQuality()->increase());
                $item->decreaseSellIn();
            })
            ->when($sellByDate)
            ->then(function (Item $item) {
                $item->updateQuality($item->getQuality()->decreaseTwice());
                $item->decreaseSellIn();
            })
            ->when($sellInDate)
            ->then(function (Item $item) {
                $item->updateQuality($item->getQuality()->decrease());
                $item->decreaseSellIn();
            })
            ->build();
    }

    /**
     * @dataProvider itemsProvider
     * @param string $name
     * @param int $sellIn
     * @param int $quality
     * @param int $expectedSellIn
     * @param int $expectedQuality
     */
    public function testUpdateQualityTest(string $name, int $sellIn, int $quality, int $expectedSellIn, int $expectedQuality): void
    {
        $item = new Item($name, $sellIn, $quality);

        $gildedRose = new GildedRose($this->behaviors);
        $gildedRose->updateItem($item);

        $this->assertEquals(SellIn::fromInteger($expectedSellIn), $item->getSellIn());
        $this->assertEquals(Quality::fromInteger($expectedQuality), $item->getQuality());
    }

    public function itemsProvider(): array
    {
        return [
            'Aged Brie before sell in date'                                    => ['Aged Brie', 10, 10, 9, 11],
            'Aged Brie sell in date'                                           => ['Aged Brie', 0, 10, -1, 12],
            'Aged Brie after sell in date'                                     => ['Aged Brie', -5, 10, -6, 12],
            'Aged Brie before sell in date with maximum quality'               => ['Aged Brie', 5, 50, 4, 50],
            'Aged Brie sell in date near maximum quality'                      => ['Aged Brie', 0, 49, -1, 50],
            'Aged Brie sell in date with maximum quality'                      => ['Aged Brie', 0, 50, -1, 50],
            'Aged Brie after_sell in date with maximum quality'                => ['Aged Brie', -10, 50, -11, 50],
            'Backstage passes before sell in date'                             => ['Backstage passes to a TAFKAL80ETC concert', 10, 10, 9, 12],
            'Backstage passes more than 10 days before sell in date'           => ['Backstage passes to a TAFKAL80ETC concert', 11, 10, 10, 11],
            'Backstage passes five days before sell in date'                   => ['Backstage passes to a TAFKAL80ETC concert', 5, 10, 4, 13],
            'Backstage passes sell in date'                                    => ['Backstage passes to a TAFKAL80ETC concert', 0, 10, -1, 0],
            'Backstage passes close to sell in date with maximum quality'      => ['Backstage passes to a TAFKAL80ETC concert', 10, 50, 9, 50],
            'Backstage passes very close to sell in date with maximum quality' => ['Backstage passes to a TAFKAL80ETC concert', 5, 50, 4, 50],
            'Backstage passes after sell in date'                              => ['Backstage passes to a TAFKAL80ETC concert', -5, 50, -6, 0],
            'Sulfuras before sell in date'                                     => ['Sulfuras, Hand of Ragnaros', 10, 80, 10, 80],
            'Sulfuras sell in date'                                            => ['Sulfuras, Hand of Ragnaros', 0, 80, 0, 80],
            'Sulfuras after sell in date'                                      => ['Sulfuras, Hand of Ragnaros', -1, 80, -1, 80],
            'Elixir of the Mongoose before sell in date'                       => ['Elixir of the Mongoose', 10, 10, 9, 9],
            'Elixir of the Mongoose sell in date'                              => ['Elixir of the Mongoose', 0, 10, -1, 8],
        ];
    }
}

<?php
declare(strict_types=1);

namespace App;

use PHPUnit\Framework\TestCase;
use App\Item\SellIn;
use App\Item\Item;
use App\Item\Quality;
use App\Specification\SellInDate;
use App\Specification\EqualName;
use App\Specification\SellInLessThanOrEqual;
use App\Specification\SellByDate;

class GildedRoseTest extends TestCase
{
    private $specifications;

    protected function setUp(): void
    {
        parent::setUp();

        $this->specifications = [
            [   (new EqualName('Sulfuras, Hand of Ragnaros')), function (Item $item) {
                $item->updateQuality(Quality::fromInteger(80));
                }
            ],
            [
                (new EqualName('Aged Brie'))->and(new SellInLessThanOrEqual(0)), function (Item $item) {
                $item->updateQuality($item->getQuality()->increaseTwice());
                $item->decreaseSellIn();
                }
            ],
            [
                (new EqualName('Aged Brie')), function (Item $item) {
                $item->updateQuality($item->getQuality()->increase());
                $item->decreaseSellIn();
            }
            ],
            [
                (new EqualName('Backstage passes to a TAFKAL80ETC concert'))->and(new SellByDate()), function (Item $item) {
                $item->updateQuality($item->getQuality()->drop());
                $item->decreaseSellIn();
            }
            ],
            [
                (new EqualName('Backstage passes to a TAFKAL80ETC concert'))->and(new SellInLessThanOrEqual(5)), function (Item $item) {
                $item->updateQuality($item->getQuality()->increaseBy(3));
                $item->decreaseSellIn();
            },
            ],
            [
                (new EqualName('Backstage passes to a TAFKAL80ETC concert'))->and(new SellInLessThanOrEqual(10)), function (Item $item) {
                $item->updateQuality($item->getQuality()->increaseTwice());
                $item->decreaseSellIn();
            }
            ],
            [
                (new EqualName('Backstage passes to a TAFKAL80ETC concert'))->and(new SellInDate()), function (Item $item) {
                $item->updateQuality($item->getQuality()->increase());
                $item->decreaseSellIn();
                }
            ],
            [
                (new SellByDate()), function(Item $item) {
                $item->updateQuality($item->getQuality()->decreaseTwice());
                $item->decreaseSellIn();
            }
            ],
            [
                (new SellInDate()), function(Item $item) {
                $item->updateQuality($item->getQuality()->decrease());
                $item->decreaseSellIn();
            }
            ]
        ];
    }

    /**
     * @dataProvider itemsProvider
     * @param string $name
     * @param int $sellIn
     * @param int $quality
     * @param int $expectedSellIn
     * @param int $expectedQuality
     */
    public function testUpdateQualityTest($name, $sellIn, $quality, $expectedSellIn, $expectedQuality): void
    {
        $item = new Item($name, $sellIn, $quality);

        $gildedRose = new GildedRose($this->specifications);
        //$gildedRose->updateQuality($item);
        $gildedRose->updateItem($item);

        $this->assertEquals(SellIn::fromInteger($expectedSellIn), $item->getSellIn());
        $this->assertEquals(Quality::fromInteger($expectedQuality), $item->getQuality());
    }

    public function itemsProvider(): array
    {
        return [
            'Aged Brie before sell in date' => ['Aged Brie', 10, 10, 9, 11],
            'Aged Brie sell in date' => ['Aged Brie', 0, 10, -1, 12],
            'Aged Brie after sell in date' => ['Aged Brie', -5, 10, -6, 12],
            'Aged Brie before sell in date with maximum quality' => ['Aged Brie', 5, 50, 4, 50],
            'Aged Brie sell in date near maximum quality' => ['Aged Brie', 0, 49, -1, 50],
            'Aged Brie sell in date with maximum quality' => ['Aged Brie', 0, 50, -1, 50],
            'Aged Brie after_sell in date with maximum quality' => ['Aged Brie', -10, 50, -11, 50],
            'Backstage passes before sell in date' => ['Backstage passes to a TAFKAL80ETC concert', 10, 10, 9, 12],
            'Backstage passes more than 10 days before sell in date' => ['Backstage passes to a TAFKAL80ETC concert', 11, 10, 10, 11],
            'Backstage passes five days before sell in date' => ['Backstage passes to a TAFKAL80ETC concert', 5, 10, 4, 13],
            'Backstage passes sell in date' => ['Backstage passes to a TAFKAL80ETC concert', 0, 10, -1, 0],
            'Backstage passes close to sell in date with maximum quality' => ['Backstage passes to a TAFKAL80ETC concert', 10, 50, 9, 50],
            'Backstage passes very close to sell in date with maximum quality' => ['Backstage passes to a TAFKAL80ETC concert', 5, 50, 4, 50],
            'Backstage passes after sell in date' => ['Backstage passes to a TAFKAL80ETC concert', -5, 50, -6, 0],
            'Sulfuras before sell in date' => ['Sulfuras, Hand of Ragnaros', 10, 80, 10, 80],
            'Sulfuras sell in date' => ['Sulfuras, Hand of Ragnaros', 0, 80, 0, 80],
            'Sulfuras after sell in date' => ['Sulfuras, Hand of Ragnaros', -1, 80, -1, 80],
            'Elixir of the Mongoose before sell in date' => ['Elixir of the Mongoose', 10, 10, 9, 9],
            'Elixir of the Mongoose sell in date' => ['Elixir of the Mongoose', 0, 10, -1, 8],
        ];
    }
}

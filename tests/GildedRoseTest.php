<?php
declare(strict_types=1);

namespace App;

use App\Item\Item;
use App\Item\Quality;
use App\Item\SellIn;
use App\Item\Specification\{
    ItemName,
    SellByDate,
    SellInDate,
    SellInLessThanOrEqual,
};
use App\Item\Strategy\Builder\StrategyBuilder;
use App\Item\Strategy\{
    DecreaseQuality,
    DecreaseQualityTwice,
    DecreaseSellIn,
    DropQuality,
    IncreaseQuality,
    IncreaseQualityBy,
    IncreaseQualityTwice,
    SetSpecialQuality,
};
use App\Item\Strategy\Factory\{StrategyFactory, UpdateStrategyFactory};
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    /**
     * @var StrategyFactory
     */
    private $strategyFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->strategyFactory = new UpdateStrategyFactory($this->getStrategyBuilder());
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

        $gildedRose = new GildedRose($this->strategyFactory);
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

    private function getStrategyBuilder(): StrategyBuilder
    {
        $sulfuras   = new ItemName('Sulfuras, Hand of Ragnaros');
        $brie       = new ItemName('Aged Brie');
        $backstage  = new ItemName('Backstage passes to a TAFKAL80ETC concert');
        $sellInDate = new SellInDate();
        $sellByDate = new SellByDate();

        return (new StrategyBuilder())
            ->when($sulfuras)
            ->then(new SetSpecialQuality())
            ->when($brie->and(SellInLessThanOrEqual::to(0)))
            ->then(new IncreaseQualityTwice(), new DecreaseSellIn())
            ->when($brie)
            ->then(new IncreaseQuality(), new DecreaseSellIn())
            ->when($backstage->and($sellByDate))
            ->then(new DropQuality(), new DecreaseSellIn())
            ->when($backstage->and(SellInLessThanOrEqual::to(5)))
            ->then(new IncreaseQualityBy(3), new DecreaseSellIn())
            ->when($backstage->and(SellInLessThanOrEqual::to(10)))
            ->then(new IncreaseQualityTwice(), new DecreaseSellIn())
            ->when($backstage->and($sellInDate))
            ->then(new IncreaseQuality(), new DecreaseSellIn())
            ->when($sellByDate)
            ->then(new DecreaseQualityTwice(), new DecreaseSellIn())
            ->when($sellInDate)
            ->then(new DecreaseQuality(), new DecreaseSellIn());
    }
}

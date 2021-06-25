<?php
declare(strict_types=1);

namespace App\Item\Strategy\Factory;

use App\Item\Item;
use App\Item\Specification\SellByDate;
use App\Item\Strategy\Builder\StrategyBuilder;
use App\Item\Strategy\DropQuality;
use LogicException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UpdateStrategyFactoryTest extends TestCase
{
    /**
     * @var StrategyBuilder|MockObject
     */
    private $builder;

    /**
     * @var UpdateStrategyFactory
     */
    private $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->builder = $this->getMockBuilder(StrategyBuilder::class)->getMock();
        $this->factory = new UpdateStrategyFactory($this->builder);
    }

    public function testCreateStrategyTwice()
    {
        $this->builder->expects($this->once())->method('build')->willReturn([
            [new SellByDate(), new DropQuality()]
        ]);
        $strategy = $this->factory->createFor(new Item('Brie', -1, 0));
        $this->assertInstanceOf(DropQuality::class, $strategy);
        $strategy = $this->factory->createFor(new Item('Brie', -1, 0));
        $this->assertInstanceOf(DropQuality::class, $strategy);
    }

    public function testNotFoundStrategy()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Strategy not found');
        $this->builder->expects($this->once())->method('build')->willReturn([
            [new SellByDate(), new DropQuality()]
        ]);

        $this->factory->createFor(new Item('Brie', 10, 10));
    }
}

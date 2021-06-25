<?php
declare(strict_types=1);

namespace App\Item\Strategy\Builder;

use App\Item\Specification\SellInDate;
use App\Item\Strategy\DecreaseSellIn;
use LogicException;
use PHPUnit\Framework\TestCase;

class StrategyBuilderTest extends TestCase
{
    /**
     * @var StrategyBuilder
     */
    private $builder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->builder = new StrategyBuilder();
    }

    public function testCannotBuildBehaviorWithoutStrategy()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Incorrect specifications and strategies count.');
        $this->builder->when(new SellInDate())->build();
    }

    public function testBuildBehavior()
    {
        $result = $this->builder->when(new SellInDate())->then(new DecreaseSellIn())->build();

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertCount(2, $result[0]);
        $this->assertInstanceOf(SellInDate::class, $result[0][0]);
        $this->assertInstanceOf(DecreaseSellIn::class, $result[0][1]);
    }
}

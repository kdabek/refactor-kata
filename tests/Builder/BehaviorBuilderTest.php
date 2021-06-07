<?php
declare(strict_types=1);

namespace App\Builder;

use LogicException;
use App\Specification\SellInDate;
use PHPUnit\Framework\TestCase;

class BehaviorBuilderTest extends TestCase
{
    /**
     * @var BehaviorBuilder
     */
    private $builder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->builder = new BehaviorBuilder();
    }

    public function testCannotBuildBehaviorWithoutCallback()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Incorrect specifications and callbacks count.');
        $this->builder->when(new SellInDate())->build();
    }

    public function testBuildBehavior()
    {
        $result = $this->builder->when(new SellInDate())->then(function () {})->build();

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertCount(2, $result[0]);
        $this->assertInstanceOf(SellInDate::class, $result[0][0]);
        $this->assertIsCallable($result[0][1]);
    }
}

<?php

declare(strict_types=1);

namespace App\Item;

use InvalidArgumentException;
use LogicException;
use PHPUnit\Framework\TestCase;

class QualityTest extends TestCase
{
    public function testTryToCreateWithNegativeValue()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Quality value must be greater than zero.');
        Quality::fromInteger(-1);
    }

    public function testCreateWithValueGreaterThanAllowed()
    {
        $quality = Quality::fromInteger(51);
        $this->assertEquals(50, $quality->getValue());
    }

    public function testCreateWithSpecialValue()
    {
        $quality = Quality::fromInteger(80);
        $this->assertEquals(80, $quality->getValue());
    }

    public function testCreate(): Quality
    {
        $quality = Quality::fromInteger(2);
        $this->assertInstanceOf(Quality::class, $quality);

        return $quality;
    }

    /**
     * @param Quality $quality
     *
     * @depends clone testCreate
     */
    public function testIncrease(Quality $quality)
    {
        $value = $quality->increase()->getValue();

        $this->assertEquals(3, $value);
    }

    /**
     * @param Quality $quality
     *
     * @depends clone testCreate
     */
    public function testDecrease(Quality $quality)
    {
        $value = $quality->decrease()->getValue();

        $this->assertEquals(1, $value);
    }

    /**
     * @param Quality $quality
     *
     * @depends clone testCreate
     */
    public function testDecreaseTwice(Quality $quality)
    {
        $value = $quality->decreaseTwice()->getValue();

        $this->assertEquals(0, $value);
    }

    /**
     * @param Quality $quality
     *
     * @depends clone testCreate
     */
    public function testDrop(Quality $quality)
    {
        $value = $quality->drop()->getValue();

        $this->assertEquals(0, $value);
    }

    /**
     * @param Quality $quality
     *
     * @depends clone testCreate
     */
    public function testCannotDecreaseLessThanZero(Quality $quality)
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Quality value must be greater than zero.');
        $quality->drop()->decrease();
    }

    /**
     * @param Quality $quality
     *
     * @depends clone testCreate
     */
    public function testCannotDecreaseTwiceLessThanZero(Quality $quality)
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Quality value must be greater than zero.');
        $quality->decrease()->decreaseTwice();
    }
}

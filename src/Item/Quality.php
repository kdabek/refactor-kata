<?php

declare(strict_types=1);

namespace App\Item;

use InvalidArgumentException;

final class Quality
{
    private const MAX_QUALITY     = 50;
    public const  SPECIAL_QUALITY = 80;

    /**
     * @var int
     */
    private $value;

    private function __construct(int $value)
    {
        $this->value = $value;
    }

    public static function fromInteger(int $value): self
    {
        if (0 > $value) {
            throw new InvalidArgumentException('Quality value must be greater than zero.');
        }

        if (self::SPECIAL_QUALITY !== $value && self::MAX_QUALITY < $value) {
            $value = self::MAX_QUALITY;
        }

        return new self($value);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function increase(): self
    {
        return self::fromInteger($this->value + 1);
    }

    public function increaseTwice(): self
    {
        return $this->increase()->increase();
    }

    public function increaseBy(int $value): self
    {
        return self::fromInteger($this->value + $value);
    }

    public function decrease(): self
    {
        return self::fromInteger($this->value - 1);
    }

    public function decreaseTwice(): self
    {
        return $this->decrease()->decrease();
    }

    public function drop(): self
    {
        return self::fromInteger(0);
    }
}

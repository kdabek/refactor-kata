<?php
declare(strict_types=1);

namespace App\Item;

class SellIn
{
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
        return new self($value);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function decrease(): self
    {
        return self::fromInteger($this->value - 1);
    }

    public function greaterThan(SellIn $other): bool
    {
        return $this->getValue() > $other->getValue();
    }

    public function lessThanOrEqual(SellIn $other): bool
    {
        return $this->getValue() <= $other->getValue();
    }
}

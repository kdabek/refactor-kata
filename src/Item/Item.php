<?php

declare(strict_types=1);

namespace App\Item;

final class Item
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var SellIn
     */
    private $sellIn;

    /**
     * @var Quality
     */
    private $quality;

    public function __construct(string $name, int $sellIn, int $quality)
    {
        $this->name    = $name;
        $this->sellIn  = SellIn::fromInteger($sellIn);
        $this->quality = Quality::fromInteger($quality);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSellIn(): SellIn
    {
        return $this->sellIn;
    }

    public function getQuality(): Quality
    {
        return $this->quality;
    }

    public function decreaseSellIn(): self
    {
        $this->sellIn = $this->sellIn->decrease();

        return $this;
    }

    public function updateQuality(Quality $quality): self
    {
        $this->quality = $quality;

        return $this;
    }
}

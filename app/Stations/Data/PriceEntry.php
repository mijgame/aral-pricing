<?php

namespace App\Stations\Data;


class PriceEntry
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var float
     */
    public $price;

    /**
     * PriceEntry constructor.
     *
     * @param string $name
     * @param float $price
     */
    public function __construct(string $name = '', float $price = 0.0)
    {
        $this->name = $name;
        $this->price = $price;
    }
}
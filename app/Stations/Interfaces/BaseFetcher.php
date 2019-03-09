<?php

namespace App\Stations\Interfaces;


interface BaseFetcher
{
    /**
     * Get pricing for the given station.
     *
     * @return mixed
     */
    public function getPricing() : array;

    /**
     * Get the name of the gas station being
     * consulted.
     *
     * @return string
     */
    public function getStationName() : string;
}
<?php

namespace App\Stations;

use App\Stations\Interfaces\BaseFetcher;

class PriceFetcher
{
    /**
     * @var BaseFetcher[]
     */
    protected $fetchers = [
        AralFetcher::class,
        AstarFetcher::class
    ];

    /**
     * @return array
     */
    public function getPricing()
    {
        $pricing = [];

        foreach ($this->fetchers as $fetcher) {
            /**
             * @var $instance BaseFetcher
             */
            $instance = new $fetcher();

            $pricing[$instance->getStationName()] = $instance->getPricing();
        }

        return $pricing;
    }
}
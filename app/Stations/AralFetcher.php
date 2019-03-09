<?php

namespace App\Stations;


use App\Stations\Data\PriceEntry;
use App\Stations\Interfaces\BaseFetcher;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AralFetcher implements BaseFetcher
{
    /**
     * @var string
     */
    protected $name = 'Aral';

    /**
     * @var array
     */
    protected $types = [
        'Aral Super E10',
        'Aral Super 95'
    ];

    /**
     * @var string
     */
    protected $url = 'http://ap.aral.de/api/v2/getStationPricesById.php?stationId=20179700';

    /**
     * Get pricing for the given station.
     *
     * @return mixed
     * @throws GuzzleException
     */
    public function getPricing() : array
    {
        $data = $this->fetchJson()['prices'];
        $result = [];

        foreach ($data as $fuelType) {
            if (!in_array($fuelType['name'], $this->types)) {
                continue;
            }

            $result[] = [
                'name' => $fuelType['name'],
                'price' => (float) str_replace(
                    ',', '.', $fuelType['price']
                )
            ];
        }

        return $result;
    }

    /**
     * Get the name of the gas station being
     * consulted.
     *
     * @return string
     */
    public function getStationName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     * @throws GuzzleException
     */
    protected function fetchJson()
    {
        $client = new Client();

        $content = $client->request('GET', $this->url)
            ->getBody()
            ->getContents();

        return json_decode($content, true)['response'];
    }
}
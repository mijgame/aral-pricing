<?php

namespace App\Stations;


use App\Stations\Interfaces\BaseFetcher;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AstarFetcher implements BaseFetcher
{
    /**
     * @var string
     */
    protected $name = 'Astar';

    /**
     * @var array
     */
    protected $types = [
        'SUPER E10',
        'SUPER'
    ];

    /**
     * @var string
     */
    protected $url = 'https://www.star.de/api/v1/station?id=star-beeker-str-250-emmerich-653';

    /**
     * Get pricing for the given station.
     *
     * @return mixed
     * @throws GuzzleException
     */
    public function getPricing() : array
    {
        $data = $this->fetchJson();
        $result = [];

        foreach ($data['fuel']['types'] as $fuelType) {
            if (!in_array($fuelType['name'], $this->types)) {
                continue;
            }

            $result[] = [
                'name' => $fuelType['name'],
                'price' => $fuelType['price'] * 100
            ] ;
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

        return json_decode($content, true);
    }
}
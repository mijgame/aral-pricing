<?php

namespace App\Aral;


use GuzzleHttp\Client;

class PriceFetcher
{
    // For Elten
    const URL = 'http://ap.aral.de/api/v2/getStationPricesById.php?stationId=20179700';

    const TYPES = [
        'Aral Super E10',
        'Aral Super 95'
    ];

    public function getPricing() {
        $data = collect($this->fetchJson()['prices']);

        $prices = $data->filter(function($object) {
            return in_array($object['name'], self::TYPES);
        });

        return $prices;
    }

    protected function fetchJson() {
        $client = new Client();

        $content = $client->request('GET', self::URL)
            ->getBody()
            ->getContents();

        return json_decode($content, true)['response'];
    }
}
<?php

namespace App\Console\Commands;

use App\GasStation;
use App\Product;
use App\Stations\PriceFetcher;
use App\Price;
use Illuminate\Console\Command;

class FetchPricing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pricing:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Aral pricing.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $requester = new PriceFetcher();

        $pricing = $requester->getPricing();
        $stations = $this->getStations();

        foreach ($pricing as $station => $products) {
            foreach ($products as $product) {
                $price = new Price();

                foreach ($stations[$station]['products'] as $sp) {
                    if ($sp['name'] != $product['name']) {
                        continue;
                    }

                    $price->product_id = $sp['id'];
                    $price->price = $product['price'];
                    $price->save();
                }
            }
        }
    }

    /**
     * @return array
     */
    protected function getStations()
    {
        $stations = GasStation::all();
        $products = Product::all();

        $stations = array_combine(
            $stations->pluck('name')->toArray(),
            $stations->toArray()
        );

        // Associate products with stations
        foreach ($products as $product) {
            foreach ($stations as &$station) {
                if ($station['id'] !== $product['gas_station_id']) {
                    continue;
                }

                if (!isset($station['products'])) {
                    $station['products'] = [];
                }

                $station['products'][] = [
                    'id' => $product['id'],
                    'name' => $product['name']
                ];

                break;
            }
        }

        return $stations;
    }
}

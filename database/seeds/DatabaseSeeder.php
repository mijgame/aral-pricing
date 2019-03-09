<?php

use App\GasStation;
use App\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $stations = [
            'Aral' => [
                'Aral Super E10',
                'Aral Super 95'
            ],
            'Astar' => [
                'SUPER E10',
                'SUPER'
            ],
        ];

        foreach ($stations as $name => $products) {
            $station = new GasStation();
            $station->name = $name;
            $station->save();

            // Get id
            $station = $station->fresh();

            foreach ($products as $name) {
                $product = new Product();
                $product->name = $name;
                $product->gas_station_id = $station->id;
                $product->save();
            }
        }
    }
}

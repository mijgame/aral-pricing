<?php

namespace App\Console\Commands;

use App\Aral\PriceFetcher;
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

        foreach ($pricing as $product) {
            $price = new Price();

            $price->station = 'Aral'; // Can be dynamic later
            $price->name = $product['name'];
            $price->price = (float) str_replace(',', '.', $product['price']); // E.g. 132,90 = 132.90 as float
            $price->currency = $product['currency']; // Always EUR

            $price->save();
        }
    }
}

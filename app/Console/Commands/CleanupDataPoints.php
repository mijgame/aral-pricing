<?php

namespace App\Console\Commands;

use App\Price;
use App\Stations\DataPointCompressor;
use Illuminate\Console\Command;

class CleanupDataPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pricing:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup pricing data by removing unnecessary data points.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = Price::with('product')
            ->get()
            ->groupBy('product.name');

        $compressor = new DataPointCompressor();

        $points = $compressor->compress($data);

        $ids = collect();
        foreach ($points as $product) {
            $ids = $ids->merge($product->pluck('id'));
        }

        Price::whereNotIn('id', $ids)->delete();
    }
}

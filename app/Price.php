<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Fill in the timestamp for created_at.
     */
    protected static function boot()
    {
        parent::boot();

        /*
         * We only have created_at, so fill in the timestamp
         * manually.
         */
        static::creating(function(Price $price) {
            $price->created_at = $price->freshTimestamp();
        });
    }

    /**
     * Get the pricing data from the last week.
     */
    public static function getLastWeek()
    {
        return Price::where('created_at', '>=', Carbon::now()->subWeek())
            ->get()
            ->groupBy('name');
    }
}

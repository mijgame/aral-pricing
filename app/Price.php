<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        static::creating(function (Price $price) {
            $price->created_at = $price->freshTimestamp();
        });
    }

    /**
     * @return BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the pricing data from the last week.
     */
    public static function getLastWeek()
    {
        return Price::where('created_at', '>=', Carbon::now()->subWeek())
            ->with('product')
            ->get()
            ->groupBy('product.name');
    }
}

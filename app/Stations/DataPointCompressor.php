<?php

namespace App\Stations;


class DataPointCompressor
{
    /**
     * Compress the given pricing timeline
     * to only the points where there is a price difference.
     *
     * @param $data
     * @return mixed
     */
    public function compress($data)
    {
        $result = [];

        foreach ($data as $product) {
            $result[] = $this->handleProduct($product);
        }

        return collect($result);
    }

    /**
     * Compress data points in the given
     * product.
     *
     * @param $product
     * @return array|\Illuminate\Support\Collection
     */
    protected function handleProduct($product)
    {
        // Save the last data point, since that will always
        // need to be there. Even if the price is the same.
        $end = $product->last();
        $result = collect([$product->first()]);

        for ($i = 1; $i < count($product); $i++) {
            if ($product[$i - 1]->price === $product[$i]->price) {
                continue;
            }

            $result[] = $product[$i];
        }

        if ($result->last() !== $end) {
            $result[] = $end;
        }

        return $result;
    }
}
<?php

use App\Helpers\StockImage;

if (! function_exists('stock_img')) {
    function stock_img(string $id): string
    {
        return StockImage::url($id);
    }
}

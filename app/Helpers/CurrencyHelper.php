<?php

use App\Models\Currency;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;

function getCurrencies()
{
    try {
        $cacheKey = 'getCurrencies';

        $getCurrencies = Utils::cacheRemember($cacheKey, function () {

            return Currency::all()->get();

        });

        return $getCurrencies;

    }catch (\Exception $e) {
        if ($e instanceof \PDOException) {
            return response()->json(Validation::error(null, explode('.', $e->getMessage())[0]));
        } else {
            return response()->json(Validation::error(null, $e->getMessage()));
        }
    }

}

 function getDollar()
{
    try {
        $cacheKey = 'getDollar';

        $getDollar = Utils::cacheRemember($cacheKey, function () {
            return Currency::where('code', 'USD')->first();
        });

        return $getDollar;
    }catch (\Exception $e) {

        if ($e instanceof \PDOException) {
            return response()->json(Validation::error(null, explode('.', $e->getMessage())[0]));
        } else {
            return response()->json(Validation::error(null, $e->getMessage()));
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
class CurrencyController extends Controller
{
    public function getPrice(Request $request)
    {
        if($request->type){
            $currency = Config::get("currencies.$request->type");
            return response()->json($currency);
        }
        return response()->json(Config::get("currencies.usd"));
    }
}

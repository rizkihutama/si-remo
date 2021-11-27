<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class SortCarPriceController extends Controller
{
    public function sortFromLowPrice(Request $request)
    {
        if ($request->wantsJson()) $cars = Car::findByPriceOrder('ASC');
        return response($cars)->header('Content-Type', 'application/json');
    }

    public function sortFromHighPrice(Request $request)
    {
        if ($request->wantsJson()) $cars = Car::findByPriceOrder('DESC');
        return response($cars)->header('Content-Type', 'application/json');
    }
}

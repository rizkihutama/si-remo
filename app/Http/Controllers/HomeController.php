<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $brands = CarBrand::all();
        $models = CarModel::all();
        $cars = Car::getCars();
        $totalCars = $cars->count();

        return view('home.index', compact('models', 'brands', 'cars', 'totalCars'));
    }

    public function carsFilter(Request $request)
    {
        $price = $request->price;
        $seats = $request->seats;
        $brands = $request->brands;
        $models = $request->models;

        if ($request->ajax()) {
            $cars = Car::getCars($price, $seats, $brands, $models);
            $totalCars = $cars->count();
            return response()->json(['cars' => $cars, 'totalCars' => $totalCars]);
        }
    }
}

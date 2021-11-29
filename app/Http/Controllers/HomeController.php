<?php

namespace App\Http\Controllers;

use App\Models\Car;
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
        $cars = Car::getCars();
        $totalCars = $cars->count();

        return view('home.index', compact('cars', 'totalCars'));
    }

    public function carsFilter(Request $request)
    {
        $price = $request->price;
        $seats = $request->seats;

        if ($request->ajax()) {
            $cars = Car::getCars($price, $seats);
            return response()->json($cars);
        }
    }
}

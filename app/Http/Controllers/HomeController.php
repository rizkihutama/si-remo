<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // if (auth()->user()->role == User::ROLE_ADMIN) {
        //     return redirect()->route('admin.dashboard');
        // }

        $cars = Car::all();
        $totalCars = $cars->count();

        return view('home.index', compact('cars', 'totalCars'));
    }
}

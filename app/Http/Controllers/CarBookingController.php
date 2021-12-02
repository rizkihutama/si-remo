<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CarBookingController extends Controller
{
    public function carDetail(Car $car)
    {
        $image = Car::getImgUrl($car->image);
        $price = Car::rupiah($car->price);
        return view('home.car-detail', compact('car', 'image', 'price'));
    }

    public function carBooking(Car $car)
    {
        $user = User::findOrFail(auth()->user()->user_id);

        return view('booking.booking', compact('car', 'user'));
    }

    public function carCheckout(Request $request)
    {
        dd($request->all());
    }
}

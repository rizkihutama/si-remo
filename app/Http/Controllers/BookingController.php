<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    private function getUser()
    {
        return User::findOrFail(auth()->user()->user_id);
    }

    private function getCar()
    {
        return Car::findOrFail(request()->car_id);
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'car_id' => [
                'required',
                'integer',
                Rule::exists('cars', 'car_id')->where(function ($query) use ($request) {
                    $query->where('car_id', $request->car_id)->where('status', 1);
                }),
            ],
            'name' => 'required|string',
            'phone' => 'required|numeric|digits_between:10,13',
            'start_date' => 'required|after:today|date_format:d/m/Y',
            'end_date' => 'required|after_or_equal:start_date|date_format:d/m/Y',
            'with_driver' => 'required',
            'pickup_location' => 'required|string',
            'pickup_time' => 'required|date_format:H:i',
            'dropoff_location' => 'required|string',
            'dropoff_time' => 'required|date_format:H:i',
        ]);
    }

    public function carDetail(Car $car)
    {
        $image = Car::getImgUrl($car->image);
        $price = Car::rupiah($car->price);
        return view('home.car-detail', compact('car', 'image', 'price'));
    }

    public function carBooking(Car $car)
    {
        $user = $this->getUser();
        $true = Booking::WITH_DRIVER_TRUE;
        $false = Booking::WITH_DRIVER_FALSE;
        $price = Car::rupiah($car->price);

        return view('booking.booking', compact('car', 'price', 'user', 'true', 'false'));
    }

    public function carBookingCreate(Request $request)
    {
        $validated = $this->validateRequest($request);
        $user = $this->getUser();
        $car = $this->getCar();
        $start_date = Booking::formatDate($request->start_date);
        $end_date = Booking::formatDate($request->end_date);
        $days = Booking::getDaysFromStartDateAndEndDate($start_date, $end_date);

        DB::beginTransaction();
        try {
            $booking = new Booking;
            $booking->fill($validated);
            $booking->user_id = $user->user_id;
            $booking->car_id = $car->car_id;
            $booking->with_driver = $booking->checkIsWithDriver($request->with_driver);
            $booking->driver_id = $booking->getDriverId($request->with_driver);
            $booking->code = $booking->generateBookingCode($user->user_id, $car->car_id);
            $booking->status = Booking::STATUS_WAITING_PAYMENT;
            $booking->start_date = $start_date;
            $booking->end_date = $end_date;
            $booking->days = $days;
            $booking->sub_total = $car->price;
            $booking->total = $booking->getTotalPrice($car->price, $days);
            $booking->save();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('home')->with('success', 'Booking success');
    }
}

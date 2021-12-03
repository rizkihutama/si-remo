<?php

namespace App\Http\Controllers;

use App\Models\Bank;
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

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'car_id' => [
                'required',
                'integer',
                Rule::exists('cars', 'car_id')->where(function ($query) use ($request) {
                    $query->where('car_id', $request->car_id)->statusAvailable();
                }),
            ],
            'name' => 'required|string',
            'phone' => 'require|numeric|digit_between:10,13',
            'start_date' => 'required|after:today|date_format:d/m/Y',
            'end_date' => 'required|after_or_equal:start_date|date_format:d/m/Y',
            'bank_id' => 'required|integer|exists:banks,bank_id',
            'with_driver' => 'required',
            'pickup_location' => 'required|string',
            'pickup_time' => 'required|date_format:H:i',
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
        $bank = Bank::pluck('name', 'bank_id');
        $true = Booking::WITH_DRIVER_TRUE;
        $false = Booking::WITH_DRIVER_FALSE;
        $price = Car::rupiah($car->price);

        return view('booking.booking', compact('car', 'price', 'user', 'bank', 'true', 'false'));
    }

    public function carBookingCreate(Request $request)
    {
        $validated = $this->validateRequest($request);
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $days = Booking::getDaysFromStartDateAndEndDate($start_date, $end_date);

        DB::beginTransaction();
        try {
            $booking = new Booking;
            $booking->fill($validated);
            $booking->start_date = $booking->formatDate($start_date);
            $booking->end_date = $booking->formatDate($end_date);
            $booking->days = $days;
            $booking->create();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Booking;
use App\Models\Checkout;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    private function validateBankRequest(Request $request)
    {
        return $request->validate([
            'bank_id' => 'required|exists:banks,bank_id',
        ]);
    }

    public function checkoutBooking(Checkout $checkout)
    {
        $banks = Bank::pluck('name', 'bank_id');
        $booking_code = $checkout->bookings->code;
        $image = $checkout->cars->getImgUrl($checkout->cars->image);
        $start_date = Checkout::formatDateFE($checkout->bookings->start_date);
        $end_date = Checkout::formatDateFE($checkout->bookings->end_date);
        $days = $checkout->bookings->days;
        $tax = Booking::TAX_RATE;
        $sub_total = Checkout::rupiah($checkout->bookings->sub_total);
        $total = Checkout::rupiah($checkout->bookings->total);
        return view('checkout.index', compact(
            'checkout',
            'banks',
            'booking_code',
            'image',
            'start_date',
            'end_date',
            'days',
            'tax',
            'sub_total',
            'total'
        ));
    }

    public function checkoutUpadate(Request $request, Checkout $checkout)
    {
        $validatedBank = $this->validateBankRequest($request->bank_id);
        $checkout->update($validatedBank);
        return redirect()->route('checkout.booking', $checkout->checkout_id);
    }

    public function myCheckout(Checkout $checkout)
    {
        return view('checkout.mycheckout', compact('checkout'));
    }
}

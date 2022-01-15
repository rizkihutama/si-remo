<?php

namespace App\Exports;

use App\Models\Checkout;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CheckoutsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function headings(): array
    {
        return [
            'checkout_id',
            'user',
            'car',
            'driver',
            'bank',
            'code',
            'status',
            'start_date',
            'end_date',
            'sub_total',
            'total',
            'rent_status',
            'fine',
        ];
    }

    public function map($checkout): array
    {
        return [
            $checkout->checkout_id,
            $checkout->users->name,
            $checkout->cars->name,
            $checkout->drivers->name ?? '-',
            $checkout->banks->name,
            $checkout->code,
            $checkout->getPaymentStatusLabelAttribute(),
            $checkout->bookings->start_date,
            $checkout->bookings->end_date,
            $checkout->sub_total,
            $checkout->total,
            $checkout->getRentStatusLabelAttribute(),
            $checkout->fine ?? '-',
        ];
    }

    public function query()
    {
        return Checkout::query()->with(['bookings', 'cars', 'drivers', 'banks', 'users']);
    }
}

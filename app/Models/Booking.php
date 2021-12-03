<?php

namespace App\Models;

use Collective\Html\Eloquent\FormAccessible;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends BaseModel
{
    use HasFactory, FormAccessible;

    const WITH_DRIVER_TRUE = 1;
    const WITH_DRIVER_FALSE = 0;

    protected $table = "bookings";
    protected $primaryKey = "booking_id";

    protected $fillable = [
        'booking_id',
        'user_id',
        'car_id',
        'start_date',
        'end_date',
        'status',
        'total_price',
        'pickup_location',
        'pickup_time',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'with_driver' => 'boolean',
    ];

    public static function getDaysFromStartDateAndEndDate($start_date, $end_date)
    {
        $startDate = new DateTime($start_date);
        $endDate = new DateTime($end_date);
        $interval = $startDate->diff($endDate);
        $days = $interval->days;
        ($days == 0) ? $days = 1 : $days;
        return $days;
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cars()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function drivers()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function banks()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}

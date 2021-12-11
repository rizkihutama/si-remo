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

    const STATUS_WAITING_PAYMENT = 0;
    const STATUS_PAID = 1;
    const STATUS_WAITING_CONFIRMATION = 2;
    const STATUS_CANCELED = 3;

    const TAX_RATE = 2;

    protected $table = "bookings";
    protected $primaryKey = "booking_id";
    protected $guarded = ["booking_id"];

    protected $fillable = [
        'user_id',
        'car_id',
        'code',
        'with_driver',
        'driver_id',
        'status',
        'start_date',
        'end_date',
        'days',
        'pickup_location',
        'pickup_time',
        'dropoff_location',
        'dropoff_time',
        'sub_total',
        'total',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public static function getDaysFromStartDateAndEndDate($start_date, $end_date)
    {
        $startDate = new DateTime($start_date);
        $endDate = new DateTime($end_date);
        $interval = $startDate->diff($endDate);
        $days = $interval->days;
        ($days == 0) ? $days = 1 : $days;
        ($start_date !== $end_date) ? $days++ : $days;
        return $days;
    }

    public function checkIsWithDriver($value)
    {
        ($value == self::WITH_DRIVER_TRUE) ? $value = self::WITH_DRIVER_TRUE : $value = self::WITH_DRIVER_FALSE;
        return $value;
    }

    public static function getDriverId($value)
    {
        $driverId = Driver::inRandomOrder()->driverAvaillable()->first()->driver_id;
        ($value == self::WITH_DRIVER_TRUE) ? $driverId : $driverId = null;
        return $driverId;
    }

    public function getTotalPrice($carPrice, $days)
    {
        $tax = $carPrice * self::TAX_RATE / 100;
        $totalPrice = ($carPrice * $days) + $tax;
        return $totalPrice;
    }

    public function generateBookingCode($userId, $carId)
    {
        $code = date('ymdHis') . $userId . $carId;
        return $code;
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function cars()
    {
        return $this->belongsTo(Car::class, 'car_id', 'car_id');
    }

    public function drivers()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'driver_id');
    }
}

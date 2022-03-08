<?php

namespace App\Models;

use Collective\Html\Eloquent\FormAccessible;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarInAndOut extends BaseModel
{
    use HasFactory, FormAccessible;

    const RENT_STATUS_NOT_RENTED = 0;
    const RENT_STATUS_RENTED = 1;
    const RENT_STATUS_RETURNED = 2;

    const LATE_CHARGE = 50000;

    const FINE_STATUS_NO_FINE = 0;
    const FINE_STATUS_NOT_PAID = 1;
    const FINE_STATUS_PAID = 2;

    protected $table = 'car_in_and_outs';
    protected $primaryKey = 'cio_id';
    protected $guarded = ['cio_id'];

    protected $fillable = [
        'code',
        'car_id',
        'user_id',
        'booking_id',
        'checkout_id',
        'rent_status',
        'car_out',
        'car_in',
        'days_rent',
        'fine',
        'fine_status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public static function rentStatusLabels()
    {
        return [
            self::RENT_STATUS_NOT_RENTED => __('Not Yet Rented'),
            self::RENT_STATUS_RENTED => __('Rented'),
            self::RENT_STATUS_RETURNED => __('Returned'),
        ];
    }

    public function getRentStatusLabelAttribute()
    {
        return $this->rentStatusBadgeLabels()[$this->rent_status];
    }

    public static function rentStatusBadgeLabels()
    {
        return [
            self::RENT_STATUS_NOT_RENTED => '<h5><span class="badge badge-secondary">Not Yet Rented</span></h5>',
            self::RENT_STATUS_RENTED => '<h5><span class="badge badge-primary">Rented</span></h5>',
            self::RENT_STATUS_RETURNED => '<h5><span class="badge badge-success">Returned</span></h5>',
        ];
    }

    public function getRentStatusBadgeLabelAttribute()
    {
        return $this->rentStatusBadgeLabels()[$this->rent_status];
    }

    public static function fineStatusLabels()
    {
        return [
            self::FINE_STATUS_NO_FINE => __('No Fine'),
            self::FINE_STATUS_NOT_PAID => __('Not Paid'),
            self::FINE_STATUS_PAID => __('Paid'),
        ];
    }

    public function getFineStatusLabelAttribute()
    {
        return $this->rentStatusBadgeLabels()[$this->fine_status];
    }

    public static function fineStatusBadgeLabels()
    {
        return [
            self::FINE_STATUS_NO_FINE => '<h5><span class="badge badge-secondary">No Fine</span></h5>',
            self::FINE_STATUS_NOT_PAID => '<h5><span class="badge badge-danger">Not Paid</span></h5>',
            self::FINE_STATUS_PAID => '<h5><span class="badge badge-success">Paid</span></h5>',
        ];
    }

    public function getFineStatusBadgeLabelAttribute()
    {
        return $this->fineStatusBadgeLabels()[$this->fine_status] ?? '-';
    }

    public static function setCarInDate($car_in)
    {
        return !empty($car_in) ? CarInAndOut::formatDate($car_in) : null;
    }

    public static function getRentDays($car_out, $car_in)
    {
        if (empty($car_in)) return null;

        $carOut = new DateTime($car_out);
        $carIn = new DateTime($car_in);
        $interval = $carOut->diff($carIn);
        $days = $interval->days;
        ($days == 0) ? $days = 1 : $days;
        ($car_out !== $car_in) ? $days++ : $days;
        return $days;
    }

    public function countFine($daysRent)
    {
        $daysOrder = $this->bookings->days;
        if ($daysRent > $daysOrder) {
            $fine = ($daysRent - $daysOrder) * $this->cars->price + self::LATE_CHARGE;
            return $fine;
        }
    }

    public function getFine()
    {
        return self::rupiah($this->fine);
    }

    public function cars()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bookings()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function checkouts()
    {
        return $this->belongsTo(Checkout::class, 'checkout_id');
    }
}

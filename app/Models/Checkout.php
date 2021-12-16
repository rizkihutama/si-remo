<?php

namespace App\Models;

use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends BaseModel
{
    use HasFactory, FormAccessible;

    const WITH_DRIVER_TRUE = 1;
    const WITH_DRIVER_FALSE = 0;

    const STATUS_WAITING_PAYMENT = 0;
    const STATUS_PAID = 1;
    const STATUS_WAITING_CONFIRMATION = 2;
    const STATUS_CANCELED = 3;

    protected $table = "checkouts";
    protected $primaryKey = "checkout_id";
    protected $guarded = ["checkout_id"];

    protected $fillable = [
        "booking_id",
        "user_id",
        "car_id",
        "with_driver",
        "driver_id",
        "bank_id",
        "code",
        "status",
        "payment_proof",
        "sub_total",
        "total",
    ];

    public static function formatDateFE($date)
    {
        return now()->parse($date)->locale('id')->isoFormat('ddd, D MMM Y');
    }

    public function paymentStatusLabels()
    {
        return [
            self::STATUS_WAITING_PAYMENT => "Menunggu Pembayaran",
            self::STATUS_PAID => "Lunas",
            self::STATUS_WAITING_CONFIRMATION => "Menunggu Konfirmasi",
            self::STATUS_CANCELED => "Dibatalkan",
        ];
    }

    public function getPaymentStatusLabelAttribute()
    {
        return $this->paymentStatusLabels()[$this->status];
    }

    public function paymentStatusBadgeLabels()
    {
        return [
            self::STATUS_WAITING_PAYMENT => '<h5><span class="badge badge-warning">Menunggu Pembayaran</span></h5>',
            self::STATUS_PAID => '<h5><span class="badge badge-success">Lunas</span></h5>',
            self::STATUS_WAITING_CONFIRMATION => '<h5><span class="badge badge-info">Menunggu Konfirmasi</span></h5>',
            self::STATUS_CANCELED => '<h5><span class="badge badge-danger">Dibatalkan</span></h5>',
        ];
    }

    public function getPaymentStatusBadgeLabelAttribute()
    {
        return $this->paymentStatusBadgeLabels()[$this->status];
    }

    public static function getImgProofPath()
    {
        return 'public/proof/';
    }

    public static function getImgProofUrl($imageName)
    {
        return '/storage/proof/' . $imageName;
    }

    public function bookings()
    {
        return $this->belongsTo(Booking::class, "booking_id", "booking_id");
    }

    public function users()
    {
        return $this->belongsTo(User::class, "user_id", "user_id");
    }

    public function cars()
    {
        return $this->belongsTo(Car::class, "car_id", "car_id");
    }

    public function drivers()
    {
        return $this->belongsTo(Driver::class, "driver_id", "driver_id");
    }

    public function banks()
    {
        return $this->belongsTo(Bank::class, "bank_id", "bank_id");
    }
}

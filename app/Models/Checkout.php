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

    const RENT_STATUS_NOT_RENTED = 0;
    const RENT_STATUS_RENTED = 1;
    const RENT_STATUS_RETURNED = 2;

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
        "rent_status",
        "fine",
    ];

    public static function paymentStatusLabels()
    {
        return [
            self::STATUS_WAITING_PAYMENT => "Menunggu Pembayaran",
            self::STATUS_WAITING_CONFIRMATION => "Menunggu Konfirmasi",
            self::STATUS_PAID => "Lunas",
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

    public static function rentStatusLabels()
    {
        return [
            self::RENT_STATUS_NOT_RENTED => "Belum Dipinjam",
            self::RENT_STATUS_RENTED => "Sedang Dipinjam",
            self::RENT_STATUS_RETURNED => "Sudah Dikembalikan",
        ];
    }

    public function getRentStatusLabelAttribute()
    {
        return $this->rentStatusLabels()[$this->rent_status];
    }

    public function rentStatusBadgeLabels()
    {
        return [
            self::RENT_STATUS_NOT_RENTED => '<h5><span class="badge badge-secondary">Belum Dipinjam</span></h5>',
            self::RENT_STATUS_RENTED => '<h5><span class="badge badge-primary">Sedang Dipinjam</span></h5>',
            self::RENT_STATUS_RETURNED => '<h5><span class="badge badge-success">Sudah Dikembalikan</span></h5>',
        ];
    }

    public function getRentStatusBadgeLabelAttribute()
    {
        return $this->rentStatusBadgeLabels()[$this->rent_status];
    }

    public function withDriverStatusBadgeLabels()
    {
        return [
            self::WITH_DRIVER_TRUE => '<h5><span class="badge badge-success">Iya</span></h5>',
            self::WITH_DRIVER_FALSE => '<h5><span class="badge badge-secondary">Tidak</span></h5>',
        ];
    }

    public function getWithDriverStatusBadgeLabelAttribute()
    {
        return $this->withDriverStatusBadgeLabels()[$this->with_driver];
    }

    public function getPaymentProof()
    {
        return $this->payment_proof
            ? '<h5><span class="badge badge-success">Sudah Upload</span></h5>'
            : '<h5><span class="badge badge-danger">Belum Upload</span></h5>';
    }

    public function scopeWaitingConfirmation($query)
    {
        return $query->where('status', self::STATUS_WAITING_CONFIRMATION);
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

    public function carInAndOuts()
    {
        return $this->hasMany(CarInAndOut::class, "checkout_id", "checkout_id");
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

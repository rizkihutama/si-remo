<?php

namespace App\Models;

use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends BaseModel
{
    use HasFactory, FormAccessible;

    const STATUS_AVAILABLE = 1;
    const STATUS_BOOKED = 2;
    const STATUS_UNAVAILABLE = 3;


    protected $table = "drivers";
    protected $primaryKey = "driver_id";
    protected $guarded = ["driver_id"];

    protected $fillable = [
        "name",
        "email",
        "phone",
        "nik",
        "license",
        "status",
        "address",
        "created_by",
        "updated_by",
        "created_at",
        "updated_at",
    ];

    protected $hidden = [
        "created_by",
        "updated_by",
        "created_at",
        "updated_at",
    ];

    public static function statusLabels()
    {
        return [
            self::STATUS_AVAILABLE => "Available",
            self::STATUS_BOOKED => "Booked",
            self::STATUS_UNAVAILABLE => "Unavailable",
        ];
    }

    public function getStatusLabelAttribute()
    {
        if (isset($this->status)) {
            $list = self::statusLabels();
            return $list[$this->status] ? $list[$this->status] : null;
        }
    }

    public static function statusBadgeLabels()
    {
        return [
            self::STATUS_AVAILABLE => '<h5><span class="badge badge-success">Available</span></h5>',
            self::STATUS_BOOKED => '<h5><span class="badge badge-warning">Booked</span></h5>',
            self::STATUS_UNAVAILABLE => '<h5><span class="badge badge-danger">Unavailable</span></h5>',
        ];
    }

    public function getStatusBadgeLabelAttribute()
    {
        if (isset($this->status)) {
            $list = self::statusBadgeLabels();
            return $list[$this->status] ? $list[$this->status] : null;
        }
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, "driver_id", "driver_id");
    }
}

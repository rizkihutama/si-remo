<?php

namespace App\Models;

use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends BaseModel
{
    use HasFactory, FormAccessible;

    const STATUS_AVAILABLE = 1;
    const STATUS_BOOKED = 2;
    const STATUS_RENTED = 3;
    const STATUS_BROKEN = 4;

    protected $table = "cars";
    protected $primaryKey = "car_id";
    protected $guarded = ["car_id"];

    protected $fillable = [
        'name',
        'brand_id',
        'model_id',
        'status',
        'year',
        'image',
        'seats',
        'luggage',
        'cc',
        'number_plates',
        'price',
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

    public static function statusLabels()
    {
        return [
            self::STATUS_AVAILABLE => __('Available'),
            self::STATUS_BOOKED => __('Booked'),
            self::STATUS_RENTED => __('Rented'),
            self::STATUS_BROKEN => __('Broken'),
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
            self::STATUS_RENTED => '<h5><span class="badge badge-info">Rented</span></h5>',
            self::STATUS_BROKEN => '<h5><span class="badge badge-danger">Broken</span></h5>',
        ];
    }

    public function getStatusBadgeLabelAttribute()
    {
        if (isset($this->status)) {
            $list = self::statusBadgeLabels();
            return $list[$this->status] ? $list[$this->status] : null;
        }
    }

    public static function getImgPath()
    {
        return 'public/cars/';
    }

    public static function getImgUrl($imageName)
    {
        return '/storage/cars/' . $imageName;
    }

    public function getImageUrlAttribute()
    {
        if (isset($this->image)) {
            return self::getImgUrl($this->image);
        }
    }

    public static function getNumberPlates($car)
    {
        return strtoupper($car);
    }

    public function carBrand()
    {
        return $this->belongsTo(CarBrand::class, 'brand_id', 'brand_id');
    }

    public function carModel()
    {
        return $this->belongsTo(CarModel::class, 'model_id', 'model_id');
    }
}

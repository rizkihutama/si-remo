<?php

namespace App\Models;

use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function scopePriceOrder($query, String $order = null)
    {
        return $query->orderBy($this->table . '.price', $order);
    }

    public function scopeStatusAvailable($query)
    {
        return $query->where($this->table . '.status', self::STATUS_AVAILABLE);
    }

    public function scopeFilterLessThenFiveSeats($query)
    {
        return $query->where($this->table . '.seats', '<', 5);
    }

    public function scopeFilterFiveToSixSeats($query)
    {
        return $query->whereBetween($this->table . '.seats', [5, 6]);
    }

    public function scopeFIlterMoreThenSixSeats($query)
    {
        return $query->where($this->table . '.seats', '>', 6);
    }

    public static function getCars($price = null, $seats = null, $brands = null, $models = null)
    {
        // $cars = DB::table('cars')->where('status', self::STATUS_AVAILABLE);
        $cars = self::statusAvailable();

        if ($price) {
            switch ($price) {
                case 'low_price':
                    $cars = $cars->priceOrder('ASC');
                    // $cars = $cars->orderBy('price', 'ASC');
                    break;
                case 'high_price':
                    $cars = $cars->priceOrder('DESC');
                    // $cars = $cars->orderBy('price', 'DESC');
                    break;
            }
        }
        if ($seats) {
            switch ($seats) {
                case 'less_then_five_seats':
                    $cars = $cars->filterLessThenFiveSeats();
                    // $cars = $cars->where('seats', '<', 5);
                    break;
                case 'five_to_six_seats':
                    $cars = $cars->filterFiveToSixSeats();
                    // $cars = $cars->whereBetween('seats', [5, 6]);
                    break;
                case 'more_then_six_seats':
                    $cars = $cars->filterMoreThenSixSeats();
                    // $cars = $cars->where('seats', '>', 6);
                    break;
                default:
                    $cars = $cars;
                    break;
            }
        }
        if ($brands) {
            $cars = $cars->whereIn('brand_id', $brands);
        }
        if ($models) {
            $cars = $cars->whereIn('model_id', $models);
        }

        return $cars->get();
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

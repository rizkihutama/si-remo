<?php

namespace App\Models;

use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBrand extends BaseModel
{
    use HasFactory, FormAccessible;

    protected $table = "car_brands";
    protected $primaryKey = "brand_id";
    protected $guarded = ["brand_id"];

    protected $fillable = [
        'brand_name',
    ];

    protected $hidden = [
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public static function findByBrandId($brandId)
    {
        $data = self::orderBy('brand_name');

        if ($brandId != null) {
            $data = $data->where('brand_id', $brandId);
        }

        return $data->get();
    }

    public function carModels()
    {
        return $this->hasMany(CarModel::class, 'brand_id', 'brand_id');
    }

    public function cars()
    {
        return $this->hasMany(Car::class, 'brand_id', 'brand_id');
    }
}

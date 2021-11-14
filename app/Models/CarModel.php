<?php

namespace App\Models;

use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends BaseModel
{
    use HasFactory, FormAccessible;

    protected $table = "car_models";
    protected $primaryKey = "model_id";
    protected $guarded = ["model_id"];

    protected $fillable = [
        'brand_id',
        'model_name',
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

    public static function findByBrandId($modelId)
    {
        $data = self::orderBy('model_name');

        if ($modelId != null) {
            $data = $data->where('brand_id', $modelId);
        }

        return $data->get();
    }

    public function carBrand()
    {
        return $this->belongsTo(CarBrand::class, 'brand_id', 'brand_id');
    }

    public function cars()
    {
        return $this->hasMany(Car::class, 'model_id', 'model_id');
    }
}

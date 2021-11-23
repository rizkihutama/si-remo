<?php

namespace App\Models;

use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends BaseModel
{
    use HasFactory, FormAccessible;

    protected $table = "drivers";
    protected $primaryKey = "driver_id";
    protected $guarded = ["driver_id"];

    protected $fillable = [
        "name",
        "email",
        "phone",
        "nik",
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
}

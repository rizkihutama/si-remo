<?php

namespace App\Models;

use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends BaseModel
{
    use HasFactory, FormAccessible;

    protected $table = "banks";
    protected $primaryKey = "bank_id";
    protected $guarded = ["bank_id"];

    protected $fillable = [
        'name',
        'account_number',
        'account_name',
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
}

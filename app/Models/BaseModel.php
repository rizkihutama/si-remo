<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Float_;

abstract class BaseModel extends Model
{
  const STATUS_ACTIVE = 1;
  const STATUS_INACTIVE = 0;

  public static function boot()
  {
    parent::boot();
    static::deleting(function ($user) {
      if ($user->hasColumn('deleted_by')) {
        $user->deleted_by = Auth::id();
        $user->save();
      }
    });
    static::creating(function ($user) {
      if ($user->hasColumn('created_by')) {
        $user->created_by = Auth::id();
      }
    });
    static::updating(function ($user) {
      if ($user->hasColumn('updated_by')) {
        $user->updated_by = Auth::id();
      }
    });
  }

  public static function statusLabels()
  {
    return [
      self::STATUS_ACTIVE => 'Aktif',
      self::STATUS_INACTIVE => 'Tidak Aktif',
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
      self::STATUS_ACTIVE => '<h5><span class="badge badge-success">Aktif</span></h5>',
      self::STATUS_INACTIVE => '<h5><span class="badge badge-danger">Tidak Aktif</span></h5>',
    ];
  }

  public function getStatusBadgeLabelAttribute()
  {
    if (isset($this->status)) {
      $list = self::statusBadgeLabels();
      return $list[$this->status] ? $list[$this->status] : null;
    }
  }

  /**
   * returns array columns
   */
  public function getTableColums()
  {
    return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
  }

  public function hasColumn($key)
  {
    return in_array($key, $this->getTableColums());
  }

  public function scopeOrdered($query, $order = 'ASC')
  {
    return $query->orderBy($this->table . '.order', $order);
  }

  public function scopeActived($query)
  {
    return $query->where($this->table . '.status', self::STATUS_ACTIVE);
  }

  public static function formatDate($value)
  {
    return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
  }

  public static function formatDateForm($value)
  {
    return now()->parse($value)->format('d/m/Y');
  }

  public static function formatTimeForm($value)
  {
    return now()->parse($value)->format('H:i');
  }

  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by', 'user_id');
  }

  public function udatedBy()
  {
    return $this->belongsTo(User::class, 'updated_by', 'user_id');
  }

  public static function rupiah($price)
  {
    if (is_float($price)) return 'Rp.' . number_format($price, 0, ',', '.');

    return 'Rp.' . number_format(floatval($price), 0, ',', '.');
  }
}

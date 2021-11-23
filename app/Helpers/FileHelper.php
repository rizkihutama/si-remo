<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FileHelper
{
  public static function upload($file, $dir)
  {
    $fileName = mt_rand(100000, 999999) . '_' . date('ymdHis') . '.' . $file->getClientOriginalExtension();
    $path = Storage::putFileAs($dir, $file, $fileName);

    return $fileName;
  }

  public static function delete($file)
  {
    Storage::disk('local')->delete($file);

    return true;
  }
}

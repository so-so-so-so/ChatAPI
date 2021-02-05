<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Chat extends Model
{
  //
  protected $fillable = [
    'message', 'value',
  ];


  //carbonによる時間設定
  public function getCreatedAtAttribute($value)
  {
    $date = Carbon::parse($value);
    //9時間プラス
    $date->addHours(9);
    //created_atなどの型
    return $date->format('Y/m/d H:i:s');
  }

  public function getUpdatedAtAttribute($value)
  {
    $date = Carbon::parse($value);
    $date->addHours(9);
    return $date->format('Y/m/d H:i:s');
  }
}

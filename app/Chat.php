<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
  //
  protected $fillable = [
    'message', 'value',
  ];
  protected $casts = [
    'birthday' => 'date:Y-m-d',
    'joined_at' => 'datetime:Y-m-d H:00',
    'created_at' => 'datetime:Y/m/d H:i:s',
  ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];

    /**
    * Author: shamscorner
    * DateTime: 16/October/2019 - 04:43:23
    *
    * from contact relationship
    *
    */
    public function fromContact()
    {
        return $this->hasOne(User::class, 'id', 'from');
    }
}

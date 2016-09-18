<?php

namespace SleepingOwl\AdminAuth\Entities;

use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    public function roles()
    {
        return $this->belongsToMany('SleepingOwl\AdminAuth\Entities\Role');
    }
}

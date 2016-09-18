<?php
/**
 * Created by PhpStorm.
 * User: Evgen
 * Date: 18.09.2016
 * Time: 7:28
 */
namespace SleepingOwl\AdminAuth\Entities;

use Cartalyst\Sentinel\Roles\EloquentRole;

class Role extends EloquentRole
{
    public function permits(){
        return $this->belongsToMany('SleepingOwl\AdminAuth\Entities\Permit');
    }

    public function setPermitsAttribute($permits)
    {
        $this->setPermissions([]);
        if (isset($permits))
            foreach($permits as $permitid)
            {
                $permit = Permit::find($permitid);
                $this->addPermission($permit->slug);
            }

        // перепрописываем отношения с таблицей permits
        $this->permits()->detach();
        if ( ! $permits) return;
        if ( ! $this->exists) $this->save();
        $this->permits()->attach($permits);

    }

    public function getPermitsAttribute()
    {
        return array_pluck($this->permits()->get()->toArray(), 'id');
    }
}
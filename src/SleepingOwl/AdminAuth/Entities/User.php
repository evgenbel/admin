<?php

namespace SleepingOwl\AdminAuth\Entities;

use Cartalyst\Sentinel\Users\EloquentUser;

class User extends EloquentUser
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static $rolesModel = 'Role';

    public function setRolesAttribute($roles)
    {
        $this->roles()->detach();
        if ( ! $roles) return;
        if ( ! $this->exists) $this->save();
        $this->roles()->attach($roles);
    }

    public function getRolesAttribute($roles)
    {
        return array_pluck($this->roles()->get(['id'])->toArray(), 'id');
    }

}

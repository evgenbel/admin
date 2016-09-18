<?php namespace SleepingOwl\AdminAuth\Database\Seeders;

use Hash;
use Illuminate\Database\Seeder;
use SleepingOwl\AdminAuth\Entities\Administrator;

class AdministratorsTableSeeder extends Seeder
{

	public function run()
	{
		/*Administrator::truncate();

		$default = [
			'username' => 'admin',
			'password' => 'SleepingOwl',
			'name'     => 'SleepingOwl Administrator'
		];

		try
		{
			Administrator::create($default);
		} catch (\Exception $e)
		{
		}*/

        //
        $admin = [
            'email'    => 'admin@admin.com',
            'password' => 'adminadmin',
        ];
        $adminUser = Sentinel::registerAndActivate($admin);
        $role = [
            'name' => 'Administrator',
            'slug' => 'admin',
            'permissions' => [
                'admin' => true,
            ]
        ];
        $adminRole = Sentinel::getRoleRepository()->createModel()->fill($role)->save();
        $adminUser->roles()->attach($adminRole);
        $role = [
            'name' => 'User',
            'slug' => 'user',
        ];
        $userRole = Sentinel::getRoleRepository()->createModel()->fill($role)->save();
        $role = [
            'name' => 'Banned',
            'slug' => 'banned',
        ];
        $banRole = Sentinel::getRoleRepository()->createModel()->fill($role)->save();
	}

}
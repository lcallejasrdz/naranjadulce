<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Str as Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('users')->truncate(); // Using truncate function so all info will be cleared when re-seeding.
		DB::table('roles')->truncate();
		DB::table('role_users')->truncate();
		DB::table('activations')->truncate();

		$admin_1 = Sentinel::registerAndActivate(array(
		    'slug'			=> Str::slug('Eduardo Callejas'),
		    'username'		=> 'lcallejasrdz',
            'password' 		=> 'asdasd',
			'first_name' 	=> 'Eduardo',
            'last_name' 	=> 'Callejas',
            'email' 		=> 'lcallejasrdz@gmail.com',
            'role_id' 		=> 1,
		));

		$adminRole = Sentinel::getRoleRepository()->createModel()->create([
			'slug' => 'administrador',
			'name' => 'Administrador',
			'permissions' => array('admin' => 1),
		]);

		$admin_1->roles()->attach($adminRole);

		for ($i=0; $i < 100; $i++) { 
			$admin = Sentinel::registerAndActivate(array(
			    'slug'			=> Str::slug('Test Name '.$i),
			    'username'		=> 'test'.$i,
	            'password' 		=> 'asdasd'.$i,
				'first_name' 	=> 'Test Name '.$i,
	            'last_name' 	=> 'Test Last Name '.$i,
	            'email' 		=> 'test'.$i.'@gmail.com',
            	'role_id' 		=> 1,
			));

			$admin->roles()->attach($adminRole);
		}

		$this->command->info('Admin User created with username lcallejasrdz and password asdasd');
    }
}

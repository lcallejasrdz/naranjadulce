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
            'password' 		=> 'asdasd',
			'first_name' 	=> 'Eduardo',
            'last_name' 	=> 'Callejas',
            'email' 		=> 'lcallejasrdz@gmail.com',
            'role_id' 		=> 1,
		));

		$admin_2 = Sentinel::registerAndActivate(array(
		    'slug'			=> Str::slug('Ricardo Zumarán'),
            'password' 		=> 'abc123',
			'first_name' 	=> 'Ricardo',
            'last_name' 	=> 'Zumarán',
            'email' 		=> 'rzumaran@rnetsys.com',
            'role_id' 		=> 1,
		));

		$adminRole = Sentinel::getRoleRepository()->createModel()->create([
			'slug' => 'administrador',
			'name' => 'Administrador',
			'permissions' => array('admin' => 1),
		]);

		$sellingRole = Sentinel::getRoleRepository()->createModel()->create([
			'slug' => 'ventas',
			'name' => 'Ventas',
			'permissions' => array('admin' => 2),
		]);

		$financesRole = Sentinel::getRoleRepository()->createModel()->create([
			'slug' => 'finanzas',
			'name' => 'Finanzas',
			'permissions' => array('admin' => 3),
		]);

		$productionRole = Sentinel::getRoleRepository()->createModel()->create([
			'slug' => 'produccion',
			'name' => 'Producción',
			'permissions' => array('admin' => 4),
		]);

		$logisticRole = Sentinel::getRoleRepository()->createModel()->create([
			'slug' => 'logistica',
			'name' => 'Logistica',
			'permissions' => array('admin' => 5),
		]);

		$admin_1->roles()->attach($adminRole);
		$admin_2->roles()->attach($adminRole);

		$this->command->info('Admin User created with email lcallejasrdz and password asdasd');
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('RoleTableSeeder');
		$this->call('UserTableSeeder');
	}
}

/**
 * Populate "role" table
 */
class RoleTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('role')->insert(array('label' => 'Administrateur', 'access_level' => 2, 'type' => 'user'));
		DB::table('role')->insert(array('label' => 'Utilisateur', 'access_level' => 1, 'type' => 'user'));
		DB::table('role')->insert(array('label' => 'Manager', 'access_level' => 3, 'type' => 'project'));
		DB::table('role')->insert(array('label' => 'Développeur', 'access_level' => 2, 'type' => 'project'));
		DB::table('role')->insert(array('label' => 'Client', 'access_level' => 1, 'type' => 'project'));
	}
}

/**
 * Populate "user" table
 */
class UserTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('user')->insert(
			array(
				'firstname' => 'Super',
				'lastname' => 'Admin',
				'email' => 'admin@sigma.com',
				'password' => Hash::make('admin'),
				'role_id' => 1,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'))
		);
	}
}



<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
	
		Role::create(
			[
				'name' => 'administrator',
				'articles_submit' => true,
				'articles_publish' => true,
				'articles_modify_others' => true,
			]
		);
		
		User::create([
			'role_id' => 1,
			'username' => strtolower(trim('farshad_hasanpour')),
			'email' => filter_var('farshad.hasanpour96@gmail.com', FILTER_VALIDATE_EMAIL),
			'password' => password_hash('secret', PASSWORD_DEFAULT),
			'name' => 'فرشاد حسن پور',
			'gender' => 'male',
		]);
		
		
    }
}

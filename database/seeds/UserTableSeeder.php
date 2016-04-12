<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->truncate();

        factory(App\User::class)->create([
            'name' => 'Willy Porte',
            'email' => 'admin@email.com',
            'role' => 'admin',
            'active' => true,
            'password' => bcrypt('secret'),
            'remember_token' => str_random(10),
        ]);
        factory(App\User::class, 49)->create();
    }
}

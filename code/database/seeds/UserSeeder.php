<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_level = \App\UserLevel::create([
            'user_level' => 'Super Admin',
            'credentials' => 'full'
        ]);
        \App\User::create([
            'user_level_id' => $user_level->id,
            'fullname' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => encrypt('admin123')
        ]);
    }
}

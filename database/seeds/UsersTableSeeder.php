<?php

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' 		=>'Jod Fedlet',
            'email' 	=>'fedletpierre15@gmail.com',
            'password'	=> bcrypt('admin'),
            'level'	=> 1
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'userName' => "Super Admin",
            'lastName' => "Super",
            'firstName' => "Admin",
            'email' => "admin_ppaw@gmail.com",
            'FK_roleId' => 1,
            'status' => 1,
            'phone' =>"0700000000",
            'dateOfBirth' =>"1999-06-18",
            'password' => bcrypt("AdminPPAW2022"),


        ]);
    }
}

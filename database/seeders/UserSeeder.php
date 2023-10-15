<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $users = [
            [
                'id' => '1', 'first_name' => 'Mr.','last_name' => 'Admin','email' => 'admin@gmail.com', 'phone' => '01786287799', 'gender' => 1, 'is_admin' => 1, 'password' => Hash::make('admin@123'), 'address' => 'Dhaka',

            ],
            [
                'id' => '2', 'first_name' => 'Nymul','last_name' => 'Islam','email' => 'towkir1997islam@gmail.com', 'phone' => '01786287789', 'gender' => 1, 'is_admin' => 1, 'password' => Hash::make('admin@123'), 'address' => 'Dhaka'
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}

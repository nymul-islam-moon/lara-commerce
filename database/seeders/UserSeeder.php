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

        $user = [
            [
                'id' => '1', 'first_name' => 'Mr.','last_name' => 'Admin','email' => 'admin@gmail.com', 'phone' => '01786287789', 'gender' => 1, 'is_admin' => 1, 'password' => Hash::make('admin@123'), 'address' => 'Dhaka',
            ],
        ];

        foreach ($user as $user) {
            User::create($user);
        }
    }
}

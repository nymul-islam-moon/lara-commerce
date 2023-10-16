<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'admin']);

        $permissions = array(
            '1' => 'user list' ,
            '2' => 'create user' ,
            '3' => 'edit user',
            '4' => 'delete user',
       );



    //     foreach( $permissions as $key => $row ) {

    //         echo $row;
    //          Permission::create($row);
    //     }

    //    $user = User::first();
    //    $user->assignRole( $role );
    }
}

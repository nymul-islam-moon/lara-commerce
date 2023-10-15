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

        $permissions = [
            [ 'name' => 'user list' ],
            [ 'name' => 'create user' ],
            [ 'name' => 'edit user' ],
            [ 'name' => 'delete user' ],
        ];

        // foreach( $permissions as $key => $permission ) {
        //     Permission::create( $permission );
        // }

        // $user = User::first();
        // $user->assignRole( $role );
    }
}

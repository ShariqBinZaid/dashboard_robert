<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Modules;
use App\Models\Packages;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Subscriptions;
use App\Models\User;
use App\Models\UserInType;
use App\Models\UserRole;
use App\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        User::create([
            'name' => 'Admin',
            'gender' => 'male',
            'email' => 'admin@test.com',
            'phone' => '123456789',
            'dob' => '1994-10-01',
            'loc' => 'United State',
            'password' => Hash::make('123456'),
            'display_picture' => 'profileimage/test.png',
            'user_type' => 'admin',
            'is_active' => '1'
        ]);
        User::create([
            'name' => 'User',
            'gender' => 'male',
            'email' => 'user@test.com',
            'phone' => '123456789',
            'dob' => '1994-10-01',
            'loc' => 'California',
            'password' => Hash::make('123456'),
            'display_picture' => 'profileimage/test.png',
            'user_type' => 'user',
            'is_active' => '1'
        ]);

        Subscriptions::create([
            'name' => 'Monthly',
            'price' => '100',
            'desc' => 'Test',
            'is_active' => 1,
        ]);
        Subscriptions::create([
            'name' => 'Yearly',
            'price' => '1000',
            'desc' => 'Test 2',
            'is_active' => 1,
        ]);

        $modules = ['Users', 'Roles', 'Clients', 'Modules'];
        foreach ($modules as  $module) {
            Modules::create([
                'name' => $module,
            ]);
        }

        Role::create([
            'role_name' => 'Super Admin',
        ]);
        Role::create([
            'role_name' => 'Admin',
        ]);
        Permission::create([
            'permission_name' => 'Modules.view',
            'module_id' => 4,
        ]);
        Permission::create([
            'permission_name' => 'Modules.create',
            'module_id' => 4,
        ]);
        Permission::create([
            'permission_name' => 'Modules.update',
            'module_id' => 4,
        ]);
        Permission::create([
            'permission_name' => 'Users.view',
            'module_id' => 1,
        ]);
        Permission::create([
            'permission_name' => 'Users.create',
            'module_id' => 1,
        ]);
        Permission::create([
            'permission_name' => 'Users.update',
            'module_id' => 1,
        ]);
        Permission::create([
            'permission_name' => 'Users.delete',
            'module_id' => 1,
        ]);
        Permission::create([
            'permission_name' => 'Roles.view',
            'module_id' => 2,
        ]);
        Permission::create([
            'permission_name' => 'Roles.create',
            'module_id' => 2,
        ]);
        Permission::create([
            'permission_name' => 'Roles.update',
            'module_id' => 2,
        ]);
        Permission::create([
            'permission_name' => 'Clients.view',
            'module_id' => 3,
        ]);

        $rolePermissions = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
        foreach ($rolePermissions as  $rolePermission) {
            RolePermission::create([
                'role_id' => 1,
                'permission_id' => $rolePermission,
            ]);
        }

        UserRole::create([
            'user_id' => 1,
            'role_id' => 1,
        ]);

        $UserTypes = ['Super Admin', 'System User', 'User', 'Moderator'];
        foreach ($UserTypes as  $UserType) {
            UserType::create([
                'name' => $UserType,
            ]);
        }

        UserInType::create([
            'user_id' => 1,
            'user_type' => 1,
        ]);

        UserInType::create([
            'user_id' => 1,
            'user_type' => 2,
        ]);
    }
}

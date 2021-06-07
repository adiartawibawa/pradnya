<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permission Seeder
        $root = Role::where('slug', 'root')->first();
        $administrator = Role::where('slug', 'administrator')->first();

        $createTasks = new Permission();
        $createTasks->name = 'Manage Users';
        $createTasks->save();
        $createTasks->roles()->attach($root);

        $editUsers = new Permission();
        $editUsers->name = 'Edit Users';
        $editUsers->save();
        $editUsers->roles()->attach($administrator);


        // Role Seeder
        $root_permission = Permission::where('slug', 'manage-users')->first();
        $administrator_permission = Permission::where('slug', 'edit-users')->first();

        $dev_role = new Role();
        $dev_role->name = 'Root';
        $dev_role->save();
        $dev_role->permissions()->attach($root_permission);

        $manager_role = new Role();
        $manager_role->name = 'Administrator';
        $manager_role->save();
        $manager_role->permissions()->attach($administrator_permission);

        // User Seeder
        $root_role = Role::where('slug', 'root')->first();
        $administrator_role = Role::where('slug', 'administrator')->first();
        $root_perm = Permission::where('slug', 'manage-users')->first();
        $administrator_perm = Permission::where('slug', 'edit-users')->first();

        $rootUser = new User();
        $rootUser->name = 'Adi Arta Wibawa';
        $rootUser->username = 'shinoda_';
        $rootUser->email = 'surat.buat.adi@gmail.com';
        $rootUser->password = Hash::make('password!@#');
        $rootUser->save();
        $rootUser->roles()->attach($root_role);
        $rootUser->permissions()->attach($root_perm);

        $admin = new User();
        $admin->name = 'Christien Fujiyama Aquilan';
        $admin->username = 'shincimey';
        $admin->email = 'christienfujiyama@gmail.com';
        $admin->password = Hash::make('charista!0!1!2');
        $admin->save();
        $admin->roles()->attach($administrator_role);
        $admin->permissions()->attach($administrator_perm);
    }
}

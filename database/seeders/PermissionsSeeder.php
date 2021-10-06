<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = App\Http\Enum::PERMISSIONS;
        $roleWorker = Role::create(['name' => 'worker']);
        $roleAdmin = Role::create(['name' => 'admin']);

        foreach ($permissions as $key => $permission) {
            foreach ($permission as $singlePermission) {
                Permission::create(['name' => $singlePermission . ' ' . $key, 'guard_name' => 'web']);
                $roleAdmin->givePermissionTo($singlePermission . ' ' . $key);
                if (in_array($key, ['schedule', 'job'])) {
                    $roleWorker->givePermissionTo($singlePermission . ' ' . $key);
                }
            }
        }

        $user = \App\Models\User::factory()->create([
            'name' => 'Worker User',
            'email' => 'worker@mail.com',
            'password' => bcrypt('123456'),
        ]);
        $user->assignRole($roleWorker);

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@mail.com',
            'password' => bcrypt('123456'),
        ]);
        $user->assignRole($roleAdmin);
    }
}

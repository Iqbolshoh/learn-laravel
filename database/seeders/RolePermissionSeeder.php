<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Super Admin topish yoki yaratish
        $admin = Admin::where('username', 'superadmin')->first();
        $roleSuperAdmin = $this->maybeCreateSuperAdminRole($admin);

        // Ruxsatlar ro‘yxati
        $permissions = [
            ['group_name' => 'dashboard', 'permissions' => ['dashboard.view', 'dashboard.edit']],
            ['group_name' => 'blog', 'permissions' => ['blog.create', 'blog.view', 'blog.edit', 'blog.delete', 'blog.approve']],
            ['group_name' => 'admin', 'permissions' => ['admin.create', 'admin.view', 'admin.edit', 'admin.delete', 'admin.approve']],
            ['group_name' => 'role', 'permissions' => ['role.create', 'role.view', 'role.edit', 'role.delete', 'role.approve']],
            ['group_name' => 'profile', 'permissions' => ['profile.view', 'profile.edit', 'profile.delete', 'profile.update']],
        ];

        // Ruxsatlarni yaratish va rollarga bog‘lash
        foreach ($permissions as $group) {
            foreach ($group['permissions'] as $permissionName) {
                $permission = Permission::firstOrCreate([
                    'name' => $permissionName,
                    'group_name' => $group['group_name'],
                    'guard_name' => 'admin',
                ]);

                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
            }
        }

        // Super admin foydalanuvchiga rolni berish
        if ($admin) {
            $admin->assignRole($roleSuperAdmin);
        }

        $this->command->info('Roles and Permissions created successfully!');
    }

    /**
     * Super Admin rolini yaratish yoki olish
     */
    private function maybeCreateSuperAdminRole($admin): Role
    {
        return Role::firstOrCreate(
            ['name' => 'superadmin', 'guard_name' => 'admin']
        );
    }
}

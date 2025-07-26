<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // پاک‌سازی قبلی‌ها برای جلوگیری از تکرار
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'create league',
            'edit league',
            'delete league',
            'view league',

            'create team',
            'edit team',
            'delete team',
            'view team',

            'add player to team',
            'view player',

            'create match',
            'edit match',
            'delete match',
            'view match',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $organizer = Role::firstOrCreate(['name' => 'organizer']);
        $coach = Role::firstOrCreate(['name' => 'coach']);
        $player = Role::firstOrCreate(['name' => 'player']);

        $admin->syncPermissions(Permission::all());

        $organizer->syncPermissions([
            'create league', 'edit league', 'delete league', 'view league',
            'create team', 'edit team', 'delete team', 'view team',
            'create match', 'edit match', 'delete match', 'view match',
            'add player to team', 'view player'
        ]);

        $coach->syncPermissions([
            'create team', 'edit team', 'view team',
            'add player to team', 'view player',
            'view match',
        ]);

        $player->syncPermissions([
            'view league', 'view team', 'view match', 'view player'
        ]);
    }
}

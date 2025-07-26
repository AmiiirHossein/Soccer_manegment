<?php

namespace Database\Seeders;

use App\Models\League;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//         User::factory(10)->create();
//
//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);

//        League::factory(10)->create()->has(User::factory());
        League::factory()
            // This tells the factory to create a relationship
            ->has(User::factory())
            ->count(5)
            ->create();
        //        $this->call(RolePermissionSeeder::class);

    }
}

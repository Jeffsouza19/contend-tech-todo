<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Task;
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
        // User::factory(10)->create();
        //        $this->call([
        //            RolesPermissionsSeeder::class,
        //        ]);
        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'teste@teste.com',
        ]);

        Task::factory(20)->create();
    }
}

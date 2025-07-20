<?php

namespace Database\Seeders;

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

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // It's often good practice to seed Users first if Posts depend on them
        // If you have a UserSeeder, call it first:
        $this->call(UserSeeder::class);


        // Or ensure some users exist if you rely on existing ones in PostFactory
        // \App\Models\User::factory(10)->create(); // Example: Create 10 users if needed

        //now call your PostSeeder

        $this->call([PostSeeder::class]);
    }
}

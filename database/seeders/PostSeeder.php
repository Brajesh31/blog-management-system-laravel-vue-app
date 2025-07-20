<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post; // <-- Import the Post model

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // How many posts do you want to create?
        $numberOfPosts = 50; // Adjust as needed

        //use the PostFactory to create posts
        Post::factory()->count($numberOfPosts)->create();


        // You can also create posts with specific states if needed
        // Example: Create 10 specific draft posts for a specific user
        // $specificUserId = 1;
        // Post::factory()->count(10)->state([
        //     'user_id' => $specificUserId,
        //     'visibility' => 'draft',
        // ])->create();

        // Optional: Output a message to the console
        $this->command->info("{$numberOfPosts} posts created successfully using PostFactory.");

    }
}

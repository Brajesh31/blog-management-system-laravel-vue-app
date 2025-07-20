<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User; // <-- Import User model
use Illuminate\Support\Str; // <-- Import Str helper for slugs
use App\Models\Post; // <-- Import Post model

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     * 
     * @var string
     */

     protected $model = Post::class;  // Ensure this points to your Post model


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate a title first
        $title = $this->faker->sentence(rand(4, 8)); //Generate a sentence with 4 to 8 words

        return [
            // Assign a user_id. This will create a new User using its factory
            //If one doesn't exist or pick a random one if they do.
            //Make sure you have a UserFactory defined
            // 'user_id' => User::factory()->create()->id,
            'user_id' => User::inRandomOrder()->first()->id,

            //use the generated title
            'title'=> $title,
            
            //Generate paragraphs for text for content
            'content' => fake()->paragraphs(rand(3, 10), true), // Generate 3 to 6 paragraphs as a single string
            
            'slug'=> Str::slug($title) . '-' . uniqid(),// Ensure uniqueness with uniqid()

             // Optionally generate a fake image URL (or set to null)
            // Adjust the probability (0.7 means 70% chance of having an image)
            'image' => fake()->optional(0.7)->imageUrl(1280, 720, 'nature', true, 'Faker'),

            // Pick a random visibility status from the allowed enum values
            'visibility' => fake()->randomElement(['draft', 'published', 'private', 'archived', 'restricted']),
            
        ];
    }
}

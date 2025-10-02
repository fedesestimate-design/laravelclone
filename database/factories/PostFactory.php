<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence();
        return [
            'user_id' => $this->faker->randomElement([1,3]),
            'thumbnail' => $this->faker->imageUrl,
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->randomHtml(4,5)
        ];
    }
}

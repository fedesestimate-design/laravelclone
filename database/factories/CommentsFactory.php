<?php

namespace Database\Factories;

use App\Models\Comments;
use App\Models\Post;
use App\Models\Tasks;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comments>
 */
class CommentsFactory extends Factory
{
    protected $model = Comments::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // randomly decide if it's a Post or Task

        if ($this->faker->boolean) {
            $commentable = Post::inRandomOrder()->first();
        } else {
            $commentable = Tasks::inRandomOrder()->first();
        }
        return [
            // 'commentable_type' => $this->faker->randomElement([\App\Models\Post::class, \App\Models\Tasks::class]),
            'user_id' => $this->faker->randomElement([2,4]),
            'commentable_type' => get_class($commentable),
            'commentable_id' => $commentable->id,
            'content' => $this->faker->sentence(),
        ];
    }
}

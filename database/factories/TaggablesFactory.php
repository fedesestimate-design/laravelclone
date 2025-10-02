<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Taggables;
use App\Models\tags;
use App\Models\Tasks;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Taggables>
 */
class TaggablesFactory extends Factory
{
    protected $model = Taggables::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if($this->faker->boolean()){
            $tagable = Post::inRandomOrder()->first();
        }else{
            $tagable = Tasks::inRandomOrder()->first();
        }
        return [
            'tag_id' => tags::inRandomOrder()->first(),
            'taggable_type' => get_class($tagable),
            'taggable_id' => $tagable
        ];
    }
}

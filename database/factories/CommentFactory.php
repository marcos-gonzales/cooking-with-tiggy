<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::find(random_int(1, 20));
        return [
            'user_input' => $this->faker->sentence(),
            'user_id' => $user->id,
            'recipe_id' => Recipe::find(random_int(4, 20)),
            'file_path' => $user->file_path
        ];
    }
}

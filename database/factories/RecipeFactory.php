<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $time = ['5', '10', '15', '20', '25', '30', '45', '60'];
        $randomTime = $time[array_rand($time)];
        $this->faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($this->faker));
        $user = User::find(random_int(1, 15));

        return [
            'name' => $this->faker->foodName(),
            'ingredients' => $this->faker->vegetableName(),
            'estimated_time' => $randomTime,
            'steps' => $this->faker->paragraph($nb = 3, $asText = false),
            'user_id' => $user->id,
            'category_id' => random_int(1,2),
            'file_path' => 'images/foods/food' . random_int(1, 13) . '.jpg',
            'created_at' => $this->faker->dateTimeBetween('-2 years')
        ];
    }
}

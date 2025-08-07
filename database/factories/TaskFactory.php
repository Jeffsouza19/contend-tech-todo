<?php

declare(strict_types = 1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = \App\Models\User::query()->inRandomOrder()->first();

        return [
            'title'       => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status'      => fake()->randomElement(['pendente', 'concluída']),
            'user_id'     => $user->getAuthIdentifier(),
        ];
    }
}

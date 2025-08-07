<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
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
        $user = User::query()->inRandomOrder()->first();

        return [
            'title'       => fake('pt_BR')->sentence(),
            'description' => fake()->paragraph(),
            'status'      => fake()->randomElement(['pendente', 'concluída']),
            'user_id'     => $user->getAuthIdentifier(),
        ];
    }
}

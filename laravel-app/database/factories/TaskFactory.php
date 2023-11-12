<?php

namespace Database\Factories;

use App\Enums\TaskStatusEnum;
use App\Models\User;
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
        return [
            'user_id'     => User::first()->id,
            'parent_id'   => null,
            'title'       => fake()->text(30),
            'description' => fake()->text(150),
            'status'      => TaskStatusEnum::Todo,
            'priority'    => fake()->numberBetween(1, 5),
        ];
    }
}

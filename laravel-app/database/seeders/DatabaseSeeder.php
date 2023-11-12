<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\TaskStatusEnum;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $first = User::factory()
               ->create([
                'name'  => 'Test User 1',
                'email' => 'firstuser@gmail.com',
           ]);

        $second = User::factory()
               ->create([
               'name'  => 'Test User 2',
               'email' => 'seconduser@gmail.com',
           ]);

        Task::factory(40)->create([
            'user_id' => $first->id
        ]);

        $parent = Task::factory()->create([
            'user_id' => $second->id
        ]);

        Task::factory(3)->create([
            'user_id'   => $second->id,
            'parent_id' => $parent->id
        ]);

        $subtask_lvl1 = Task::factory()->create([
            'user_id'   => $second->id,
            'parent_id' => $parent->id
        ]);

        $subtask_lvl2 = Task::factory()->create([
            'user_id'   => $second->id,
            'parent_id' => $subtask_lvl1->id,
            'status'    => TaskStatusEnum::Done,
        ]);

        Task::factory()->create([
            'user_id'   => $second->id,
            'parent_id' => $subtask_lvl2->id
        ]);

           /*
            Task::factory(50)->state(new Sequence(
                fn ($sequence) => ['user_id' => User::all()->random()],
            ));
           */
    }
}

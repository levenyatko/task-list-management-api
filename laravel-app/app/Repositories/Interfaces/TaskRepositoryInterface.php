<?php

/**
 *
 * @class TaskRepositoryInterface
 * @package App\Repositories\Interfaces
 */

namespace App\Repositories\Interfaces;

use App\DTOs\Task\CreateTaskDTO;
use App\DTOs\Task\UpdateTaskDTO;
use App\Models\Task;

interface TaskRepositoryInterface
{
    public function create(CreateTaskDTO $data);

    public function update(Task $task, UpdateTaskDTO $new_data);


}

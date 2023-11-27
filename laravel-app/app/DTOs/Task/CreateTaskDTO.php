<?php

/**
 *
 * @class CreateTaskDTO
 * @package App\DTOs\Task
 */

namespace App\DTOs\Task;

use App\Enums\TaskStatusEnum;
use App\Http\Requests\Task\StoreTaskRequest;

class CreateTaskDTO
{
    public function __construct(
        public int $user_id,
        public string $title,
        public string $description,
        public TaskStatusEnum $status,
        public int $priority,
        public int|null $parent_id,
    ) {
    }

}

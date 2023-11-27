<?php

/**
 *
 * @class UpdateTaskDTO
 * @package App\DTOs\Task
 */

namespace App\DTOs\Task;

use App\Enums\TaskStatusEnum;
use App\Http\Requests\Task\UpdateTaskRequest;

class UpdateTaskDTO
{
    public function __construct(
        public string $title,
        public string $description,
        public TaskStatusEnum $status,
        public int $priority,
        public int|null $parent_id
    ) {
    }

}

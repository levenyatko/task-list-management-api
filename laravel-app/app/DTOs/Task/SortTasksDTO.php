<?php

/**
 *
 * @class FilterTasksDTO
 * @package App\DTOs\Task
 */

namespace App\DTOs\Task;

use App\Enums\TaskStatusEnum;
use App\Http\Requests\Task\StoreTaskRequest;

class SortTasksDTO
{
    public function __construct(
        public readonly string $priority = '',
        public readonly string $createdAt = '',
        public readonly string $completedAt = '',
    ) {
    }

    public function toArray(): array
    {
        return [
            'priority'     => $this->priority,
            'created_at'   => $this->createdAt,
            'completed_at' => $this->completedAt,
        ];
    }
}

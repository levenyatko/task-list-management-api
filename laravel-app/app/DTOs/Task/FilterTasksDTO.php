<?php

/**
 *
 * @class FilterTasksDTO
 * @package App\DTOs\Task
 */

namespace App\DTOs\Task;

use App\Enums\TaskStatusEnum;
use App\Http\Requests\Task\StoreTaskRequest;

class FilterTasksDTO
{
    public function __construct(
        public readonly int $user_id,
        public readonly string $title,
        public readonly string $description,
        public readonly string $status,
        public readonly int $priority,
    ) {
    }

    public function getFilled(): array
    {
        return array_filter($this->all());
    }

    public function all(): array
    {
        return [
            'user_id'     => $this->user_id,
            'title'       => $this->title,
            'description' => $this->description,
            'status'      => $this->status,
            'priority'    => $this->priority,
        ];
    }
}

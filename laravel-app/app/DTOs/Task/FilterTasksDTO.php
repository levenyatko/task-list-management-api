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
        public int $user_id,
        public string $title,
        public string $description,
        public string $status,
        public int $priority,
    ) {
    }

    public function toArray(): array
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

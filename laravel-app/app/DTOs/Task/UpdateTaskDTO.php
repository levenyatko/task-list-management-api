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
        public readonly string $title,
        public readonly string $description,
        public readonly string $status,
        public readonly int $priority,
        public readonly int|null $parent_id
    ) {
    }

    public static function fromRequest(UpdateTaskRequest $request): UpdateTaskDTO
    {
        $validated = $request->validated();

        return new self(
            $validated['title'],
            $validated['description'],
            TaskStatusEnum::Todo->value,
            $validated['priority'],
            $validated['parent']
        );
    }

    public function all(): array
    {
        return [
            'title'       => $this->title,
            'description' => $this->description,
            'status'      => $this->status,
            'priority'    => $this->priority,
            'parent_id'   => (empty($this->parent_id)) ? null : $this->parent_id,
        ];
    }
}

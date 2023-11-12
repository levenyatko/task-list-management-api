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
        public readonly int $user_id,
        public readonly string $title,
        public readonly string $description,
        public readonly string $status,
        public readonly int $priority,
        public readonly int|null $parent_id,
    ) {
    }

    public static function fromRequest(StoreTaskRequest $request): CreateTaskDTO
    {
        $user_id   = $request->user()->id;
        $validated = $request->validated();

        $parent_id = null;
        if (! empty($validated['parent'])) {
            $parent_id = $validated['parent'];
        }

        return new self(
            $user_id,
            $validated["title"],
            $validated["description"],
            TaskStatusEnum::Todo->value,
            $validated['priority'],
            $parent_id
        );
    }

    public function all(): array
    {
        return [
            'user_id'     => $this->user_id,
            'title'       => $this->title,
            'description' => $this->description,
            'status'      => $this->status,
            'priority'    => $this->priority,
            'parent_id'   => $this->parent_id,
        ];
    }
}

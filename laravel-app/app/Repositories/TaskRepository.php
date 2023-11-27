<?php

/**
 * Task Repository class.
 *
 * @class TaskRepository
 * @package App\Repositories
 */

namespace App\Repositories;

use App\DTOs\Task\CreateTaskDTO;
use App\DTOs\Task\UpdateTaskDTO;
use App\Enums\TaskStatusEnum;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Support\Carbon;

class TaskRepository implements TaskRepositoryInterface
{
    /**
     * @param CreateTaskDTO $data
     * @return mixed
     */
    public function create(CreateTaskDTO $data): Task
    {
        return Task::create([
            'user_id'     => $data->user_id,
            'title'       => $data->title,
            'description' => $data->description,
            'status'      => $data->status,
            'priority'    => $data->priority,
            'parent_id'   => $data->parent_id,
        ]);
    }

    /**
     * Update task.
     *
     * @param Task $task Task to update.
     * @param UpdateTaskDTO $new_data New task data.
     *
     * @return Task
     */
    public function update(Task $task, UpdateTaskDTO $new_data): Task
    {
        $task->update([
            'title'       => $new_data->title,
            'description' => $new_data->description,
            'status'      => $new_data->status,
            'priority'    => $new_data->priority,
            'parent_id'   => (empty($new_data->parent_id)) ? null : $new_data->parent_id,
        ]);

        return $task;
    }

    /**
     * Find task by ID or fail.
     *
     * @param int $taskId ID to get Task.
     * @return Task
     */
    public function getById(int $taskId): Task
    {
        return Task::findOrFail($taskId);
    }

    /**
     * Is task owned by user.
     * @param int $taskId Task to check owner.
     * @param int $userId Possible owner.
     * @return bool
     */
    public static function isOwnedBy(int $taskId, int $userId): bool
    {
        $task = Task::find($taskId);
        if ($task && $userId == $task->user_id) {
            return true;
        }
        return false;
    }

    public function isCompleted(Task $task): bool
    {
        if (TaskStatusEnum::DONE === $task->status) {
            return true;
        }
        return false;
    }

    public function complete(Task $task)
    {
        $task->status = TaskStatusEnum::DONE;
        $task->completed_at = Carbon::now()->toDateTimeString();
        $task->save();
    }

    /**
     * Check if task has uncompleted subtasks.
     *
     * @param Task $task Task to check.
     * @param bool $haveUncompleted
     * @return bool
     */
    public function haveUncompletedSubtasks(Task $task, bool $haveUncompleted = false): bool
    {
        $subtasks = $task->subTasks()->get();

        foreach ($subtasks as $subtask) {
            if ($this->isCompleted($subtask)) {
                $haveUncompleted = $this->haveUncompletedSubtasks($subtask, $haveUncompleted);
            } else {
                return true;
            }
        }

        return $haveUncompleted;
    }

    public function getFilteredData(array $filter_data, array $sort_data)
    {
        $where_filter = [];

        if (!empty($filter_data)) {
            foreach ($filter_data as $key => $value) {
                if (in_array($key, ['title', 'description'])) {
                    $where_filter[] = [$key, 'LIKE', '%' . $value . '%'];
                } else {
                    $where_filter[] = [$key, $value];
                }
            }
        }

        $tasks = Task::where($where_filter);

        if (!empty($sort_data)) {
            foreach ($sort_data as $field => $order) {
                $tasks->orderBy($field, $order);
            }
        }
        return $tasks;
    }
}

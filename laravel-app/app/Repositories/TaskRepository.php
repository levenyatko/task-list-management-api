<?php

/**
 * Task Repository class.
 *
 * @class TaskRepository
 * @package App\Repositories
 */

namespace App\Repositories;

use App\DTOs\Task\CreateTaskDTO;
use App\DTOs\Task\FilterTasksDTO;
use App\DTOs\Task\SortTasksDTO;
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
    public static function create(CreateTaskDTO $data): Task
    {
        return Task::create($data->all());
    }

    /**
     * Update task.
     *
     * @param Task $task Task to update.
     * @param UpdateTaskDTO $new_data New task data.
     *
     * @return Task
     */
    public static function update(Task $task, UpdateTaskDTO $new_data): Task
    {
        $task->update($new_data->all());

        return $task;
    }

    /**
     * Find task by ID or fail.
     *
     * @param int $taskId ID to get Task.
     * @return Task
     */
    public static function getById(int $taskId): Task
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

    public static function isCompleted(Task $task): bool
    {
        if (TaskStatusEnum::Done === $task->status) {
            return true;
        }
        return false;
    }

    /**
     * Delete task.
     *
     * @param Task $task Task to delete.
     * @return void
     */
    public static function delete(Task $task): void
    {
        $task->delete();
    }

    public static function complete(Task $task)
    {
        $task->status = TaskStatusEnum::Done;
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
    public static function haveUncompletedSubtasks(Task $task, bool $haveUncompleted = false): bool
    {
        $subtasks = $task->subTasks()->get();

        foreach ($subtasks as $subtask) {
            if (self::isCompleted($subtask)) {
                $haveUncompleted = self::haveUncompletedSubtasks($subtask, $haveUncompleted);
            } else {
                return true;
            }
        }

        return $haveUncompleted;
    }

    public static function getFilteredData(FilterTasksDTO $filter, SortTasksDTO $sort)
    {
        $where_filter = [];

        $filter_data = $filter->getFilled();
        $sort_data   = $sort->getFilled();

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

<?php

/**
 *
 * @class TaskService
 * @package App\Services\Api
 */

namespace App\Services\Api;

use App\DTOs\Task\CreateTaskDTO;
use App\DTOs\Task\FilterTasksDTO;
use App\DTOs\Task\SortTasksDTO;
use App\DTOs\Task\UpdateTaskDTO;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\TaskRepository;

class TaskService
{
    private TaskRepositoryInterface $repository;

    public function __construct(TaskRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Change service's task repository.
     * @param TaskRepositoryInterface $repository New task repository.
     * @return void
     */
    public function setRepository(TaskRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get Filtered and ordered tasks list.
     * @param FilterTasksDTO $filter Tasks filter data.
     * @param SortTasksDTO $sort Tasks order data.
     * @return mixed
     */
    public function getFilteredTasks(FilterTasksDTO $filter, SortTasksDTO $sort)
    {
        $filter_data = array_filter($filter->toArray());
        $sort_data   = array_filter($sort->toArray());

        return $this->repository->getFilteredData($filter_data, $sort_data);
    }

    /**
     * Create new Task.
     * @param CreateTaskDTO $data Task data.
     * @return mixed
     */
    public function storeTask(CreateTaskDTO $data)
    {
        return $this->repository->create($data);
    }

    /**
     * Update task data.
     *
     * @param Task $task Task to update.
     * @param UpdateTaskDTO $data New data for task.
     *
     * @return Task|mixed
     */
    public function updateTask(Task $task, UpdateTaskDTO $data)
    {
        return $this->repository->update($task, $data);
    }

    /**
     * Delete task.
     *
     * @param Task $task Task to delete.
     * @return void
     */
    public function deleteTask(Task $task): void
    {
        $task->delete();
    }

    /**
     * Check if status was done.
     *
     * @param Task $task
     * @return bool
     */
    public function isTaskCompleted(Task $task): bool
    {
        return $this->repository->isCompleted($task);
    }

    /**
     * Complete task.
     *
     * @param Task $task Task to complete.
     * @return bool
     */
    public function completeTask(Task $task): bool
    {
        if (!$this->repository->haveUncompletedSubtasks($task)) {
            $this->repository->complete($task);
            return true;
        }
        return false;
    }
}

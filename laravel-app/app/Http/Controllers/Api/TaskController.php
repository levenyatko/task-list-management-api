<?php

namespace App\Http\Controllers\Api;

use App\DTOs\Task\CreateTaskDTO;
use App\DTOs\Task\UpdateTaskDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\ListTasksRequest;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\DeletedResource;
use App\Http\Resources\Task\TaskCollection;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use App\Services\Api\TaskService;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('resource.owner', ['only' => ['show', 'update', 'destroy', 'complete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param ListTasksRequest $request Request to filter data.
     * @param TaskService $service Service to perform logic.
     * @return TaskCollection
     */
    public function index(ListTasksRequest $request, TaskService $service): TaskCollection
    {
        $tasks = $service->getFilteredTasks($request->getFilterData(), $request->getSortData())->paginate(10);

        return new TaskCollection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTaskRequest $request Request with new object data.
     * @param TaskService $service Service to perform logic.
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTaskRequest $request, TaskService $service): \Illuminate\Http\JsonResponse
    {
        $created = $service->storeTask($request->getTaskData());

        if ($created) {
            return response()->json(new TaskResource($created), 201);
        }
        return response()->json(['message' => 'Failed to create Task.'], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task Task to show.
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Task $task): \Illuminate\Http\JsonResponse
    {
        return response()->json(new TaskResource($task));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTaskRequest $request Request with new object data.
     * @param Task $task Object to change data.
     * @param TaskService $service Service to perform logic.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTaskRequest $request, Task $task, TaskService $service): \Illuminate\Http\JsonResponse
    {
        $updated = $service->updateTask($task, $request->getTaskData());

        if ($updated) {
            return response()->json(new TaskResource($updated));
        }
        return response()->json(['message' => 'Failed to update Task.'], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task Task to destroy.
     * @param TaskService $service Service to perform destroy logic.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task, TaskService $service): \Illuminate\Http\JsonResponse
    {
        if (!$service->isTaskCompleted($task)) {

            try{
                $service->deleteTask($task);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Failed to delete the task.'
                ], 400);
            }

            return response()->json(new DeletedResource($task));

        }

        return response()->json([
            'message' => 'Completed tasks cannot be deleted.'
        ], 400);
    }

    /**
     * Set task status to done.
     *
     * @param Task $task Task to complete.
     * @param TaskService $service Service to perform logic.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function complete(Task $task, TaskService $service): \Illuminate\Http\JsonResponse
    {
        if (!$service->isTaskCompleted($task)) {
            $completed = $service->completeTask($task);

            if ($completed) {
                return response()->json(new TaskResource($task));
            }
            return response()->json(['message' => 'Failed to finish the Task. You should finish all subtasks.'], 400);
        }
        return response()->json(['message' => 'The task is already completed.'], 400);
    }
}

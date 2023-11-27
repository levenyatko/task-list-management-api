<?php

/**
 *
 * @class StoreTaskRequest
 * @package App\Http\Requests\Task
 */

namespace App\Http\Requests\Task;

use App\DTOs\Task\CreateTaskDTO;
use App\Enums\TaskStatusEnum;
use App\Rules\TaskOwnership;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:100',
            'description' => 'string|max:255',
            'priority'    => 'required|integer|min:1|max:5',
            'parent'      => [
                'required',
                'exists_or_null:tasks,id',
                new TaskOwnership(),
            ],
        ];
    }

    public function getTaskData(): CreateTaskDTO
    {
        $validated = $this->validated();
        $user_id   = $this->user()->id;

        $parent_id = null;
        if (! empty($validated['parent'])) {
            $parent_id = $validated['parent'];
        }

        return new CreateTaskDTO(
            $user_id,
            $validated["title"],
            $validated["description"],
            TaskStatusEnum::TODO,
            $validated['priority'],
            $parent_id
        );
    }
}

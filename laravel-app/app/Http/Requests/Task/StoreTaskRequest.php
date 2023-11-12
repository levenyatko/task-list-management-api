<?php

/**
 *
 * @class StoreTaskRequest
 * @package App\Http\Requests\Task
 */

namespace App\Http\Requests\Task;

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
}

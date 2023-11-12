<?php

/**
 *
 * @class ListTasksRequest
 * @package App\Http\Requests\Task
 */

namespace App\Http\Requests\Task;

use App\DTOs\Task\FilterTasksDTO;
use App\DTOs\Task\SortTasksDTO;
use App\Enums\SortOrderEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ListTasksRequest extends FormRequest
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
            'filter.title'       => 'string|max:100',
            'filter.description' => 'string|max:255',
            'filter.priority'    => 'integer|min:1|max:5',
            'filter.status'      => Rule::enum(TaskStatusEnum::class),
            'sort.priority'      => Rule::enum(SortOrderEnum::class),
            'sort.createdAt'     => Rule::enum(SortOrderEnum::class),
            'sort.completedAt'   => Rule::enum(SortOrderEnum::class),
        ];
    }

    /**
     * Get request filter data only.
     *
     * @return FilterTasksDTO
     */
    public function getFilterData(): FilterTasksDTO
    {
        $userId = $this->user()->id;
        $validated = $this->validated('filter');

        return new FilterTasksDTO(
            $userId,
            $validated['title'] ?? '',
            $validated['description'] ?? '',
            $validated['status'] ?? '',
            $validated['priority'] ?? 0,
        );
    }

    /**
     * Get request filter data only.
     *
     * @return SortTasksDTO
     */
    public function getSortData(): SortTasksDTO
    {
        $validated = $this->validated('sort');

        return new SortTasksDTO(
            $validated['priority'] ?? '',
            $validated['createdAt'] ?? '',
            $validated['completedAt'] ?? '',
        );
    }
}

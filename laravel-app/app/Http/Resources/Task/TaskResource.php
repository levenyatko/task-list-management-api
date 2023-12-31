<?php

namespace App\Http\Resources\Task;

use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->resource->id,
            'title'        => $this->resource->title,
            'description'  => $this->resource->description,
            'status'       => $this->resource->status,
            'priority'     => $this->resource->priority,
            'owner_id'     => $this->resource->user_id,
            'parent_id'    => $this->resource->parent_id,
            'created_at'   => Carbon::parse($this->resource->created_at)->format(DateTime::ATOM),
            'completed_at' => Carbon::parse($this->resource->completed_at)->format(DateTime::ATOM),
        ];
    }
}

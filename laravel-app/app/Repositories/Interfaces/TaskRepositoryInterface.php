<?php

/**
 *
 * @class TaskRepositoryInterface
 * @package App\Repositories\Interfaces
 */

namespace App\Repositories\Interfaces;

use App\DTOs\Task\CreateTaskDTO;

interface TaskRepositoryInterface
{
    public static function create(CreateTaskDTO $data);
}

<?php

/**
 * Enum with task statuses.
 *
 * @class Status
 * @package App\Enums
 */

namespace App\Enums;

use App\Traits\EnumToArray;

enum TaskStatusEnum: string
{
    use EnumToArray;

    case Todo = 'ToDo';
    case Done = 'Done';
}

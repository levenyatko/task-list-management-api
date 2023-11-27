<?php

/**
 * Enum with task statuses.
 *
 * @class Status
 * @package App\Enums
 */

namespace App\Enums;

enum TaskStatusEnum: int{
    case TODO = 20;
    case DONE = 40;
}

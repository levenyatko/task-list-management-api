<?php

/**
 * Enum with available sort orders.
 *
 * @class Status
 * @package App\Enums
 */

namespace App\Enums;

enum SortOrderEnum: string
{
    case ASC = 'asc';
    case DESC = 'desc';
}

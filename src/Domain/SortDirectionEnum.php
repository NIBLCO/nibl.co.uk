<?php

namespace App\Domain;

use MyCLabs\Enum\Enum;

/**
 * @psalm-immutable
 * @method static SortDirectionEnum ASC()
 * @method static SortDirectionEnum DESC()
 */
final class SortDirectionEnum extends Enum
{
    private const ASC = 'ASC';
    private const DESC = 'DESC';
}

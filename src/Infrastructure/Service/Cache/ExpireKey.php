<?php

namespace App\Infrastructure\Service\Cache;

abstract class ExpireKey
{
    public const EXPIRE_IN_HOUR = 3600;
    public const EXPIRE_IN_10_MIN = 300;
}

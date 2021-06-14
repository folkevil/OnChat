<?php

declare(strict_types=1);

namespace app\util;

use think\facade\Cache;

class Redis
{
    public static function getHandler()
    {
        return Cache::store('redis')->handler();
    }
}

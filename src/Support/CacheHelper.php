<?php

namespace Hzmwdz\TinyRegion\Support;

use Illuminate\Support\Facades\Config;

class CacheHelper
{
    public const NAME = 'tiny-region';

    /**
     * @return string
     */
    public static function prefix()
    {
        return Config::get(self::NAME . '.cache_prefix');
    }

    /**
     * @return string
     */
    public static function ttl()
    {
        return Config::get(self::NAME . '.cache_ttl');
    }

    /**
     * @param int $id
     * @return string
     */
    public static function keyForRegion($id)
    {
        $prefix = self::prefix();

        return "{$prefix}.region.{$id}";
    }

    /**
     * @param int $parentId
     * @return string
     */
    public static function keyForAllRegions($parentId = 0)
    {
        $prefix = self::prefix();

        return "{$prefix}.region.all_by_parent_id.{$parentId}";
    }
}

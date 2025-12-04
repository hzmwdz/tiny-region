<?php

namespace Hzmwdz\TinyRegion\Support;

use Illuminate\Support\Facades\Lang;

class TransHelper
{
    public const NAME = 'tiny-region';

    /**
     * @param int $id
     * @return string
     */
    public static function parentRegionNotFound($id)
    {
        $key = self::NAME . "::messages.parent_region_not_found";

        return Lang::get($key, ['id' => $id]);
    }

    /**
     * @param int $id
     * @return string
     */
    public static function regionNotFound($id)
    {
        $key = self::NAME . "::messages.region_not_found";

        return Lang::get($key, ['id' => $id]);
    }
}

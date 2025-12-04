<?php

namespace Hzmwdz\TinyRegion\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'name',
        'native',
        'translations',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'translations' => 'array',
    ];
}

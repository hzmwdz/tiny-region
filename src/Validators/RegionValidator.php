<?php

namespace Hzmwdz\TinyRegion\Validators;

use Illuminate\Support\Facades\Validator;

class RegionValidator
{
    /**
     * @param array $data
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function validate($data)
    {
        return Validator::make($data, [
            'parent_id' => 'required|integer|min:0',
            'name' => 'required|string|max:255',
            'native' => 'required|string|max:255',
            'translations' => 'nullable|array',
        ])->validate();
    }
}

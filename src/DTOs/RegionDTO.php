<?php

namespace Hzmwdz\TinyRegion\DTOs;

class RegionDTO
{
    /**
     * @var int
     */
    public $parentId;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $native;

    /**
     * @var array|null
     */
    public $translations;

    /**
     * @param array $data
     */
    public function __construct($data)
    {
        $this->parentId = $data['parent_id'];
        $this->name = $data['name'];
        $this->native = $data['native'];
        $this->translations = $data['translations'] ?? null;
    }
}

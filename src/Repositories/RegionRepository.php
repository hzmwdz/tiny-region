<?php

namespace Hzmwdz\TinyRegion\Repositories;

use Hzmwdz\TinyCore\Exceptions\BusinessException;
use Hzmwdz\TinyRegion\Models\Region;
use Hzmwdz\TinyRegion\Support\CacheHelper;
use Hzmwdz\TinyRegion\Support\TransHelper;
use Illuminate\Support\Facades\Cache;

class RegionRepository
{
    /**
     * @param int $parentId
     * @return \Illuminate\Support\Collection
     */
    public function getAll($parentId = 0)
    {
        $key = CacheHelper::keyForAllRegions($parentId);

        return Cache::remember($key, CacheHelper::ttl(), function () use ($parentId) {
            return Region::where('parent_id', $parentId)->get();
        });
    }

    /**
     * @param int $id
     * @return \Hzmwdz\TinyRegion\Models\Region|null
     */
    public function find($id)
    {
        $key = CacheHelper::keyForRegion($id);

        $item = Cache::get($key);

        if ($item !== null) {
            return $item;
        }

        $item = Region::find($id);

        if ($item !== null) {
            Cache::put($key, $item, CacheHelper::ttl());
        }

        return $item;
    }

    /**
     * @param \Hzmwdz\TinyRegion\DTOs\RegionDTO $dto
     * @return \Hzmwdz\TinyRegion\Models\Region
     * @throws \Hzmwdz\TinyCore\Exceptions\BusinessException
     */
    public function create($dto)
    {
        $parent = $this->find($dto->parentId);

        if (!$parent) {
            throw new BusinessException(TransHelper::parentRegionNotFound($dto->parentId));
        }

        $item = Region::create([
            'parent_id' => $parent->id,
            'name' => $dto->name,
            'native' => $dto->native,
            'translations' => !empty($dto->translations) ? json_encode($dto->translations) : null,
        ]);

        Cache::forget(CacheHelper::keyForAllRegions($item->parent_id));

        return $item;
    }

    /**
     * @param int $id
     * @param \Hzmwdz\TinyRegion\DTOs\RegionDTO $dto
     * @return bool
     * @throws \Hzmwdz\TinyCore\Exceptions\BusinessException
     */
    public function update($id, $dto)
    {
        $item = $this->find($id);

        if (!$item) {
            throw new BusinessException(TransHelper::regionNotFound($id));
        }

        $parent = $this->find($dto->parentId);

        if (!$parent) {
            throw new BusinessException(TransHelper::parentRegionNotFound($dto->parentId));
        }

        $oldParentId = $item->parent_id;
        $newParentId = $parent->id;

        $result = $item->update([
            'parent_id' => $newParentId,
            'name' => $dto->name,
            'native' => $dto->native,
            'translations' => !empty($dto->translations) ? json_encode($dto->translations) : null,
        ]);

        Cache::forget(CacheHelper::keyForAllRegions($oldParentId));

        Cache::forget(CacheHelper::keyForAllRegions($newParentId));

        Cache::forget(CacheHelper::keyForRegion($item->id));

        return $result;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Hzmwdz\TinyCore\Exceptions\BusinessException
     */
    public function delete($id)
    {
        $item = $this->find($id);

        if (!$item) {
            throw new BusinessException(TransHelper::regionNotFound($id));
        }

        $result = $item->delete();

        Cache::forget(CacheHelper::keyForAllRegions($item->parent_id));

        Cache::forget(CacheHelper::keyForRegion($item->id));

        return $result;
    }
}

<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Group;
use App\Traits\PermissionMap;

trait GroupMap
{
    use PermissionMap {
        mapList as permissionMapList;
        map as permissionMap;
    }

    /**
     * Map for group model
     *
     * @param Group $group
     * @return array
     */
    private function map(Group $group): array
    {
        return [
            'id' => $group->getId(),
            'name' => $group->getName(),
            'permissions' => $this->permissionMapList(
                $group->permissions,
                'permissionMap'
            ),
        ];
    }

    /**
     * Map list
     *
     * @param Collection $groups
     * @return array
     */
    private function mapList(Collection $groups, string $method = 'map'): array
    {
        return $groups->map(function ($group) use ($method) {
            return $this->$method($group);
        })->toArray();
    }
}
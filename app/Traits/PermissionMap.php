<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Permission;

trait PermissionMap
{
    /**
     * Map for permission model
     *
     * @param Permission $permission
     * @return array
     */
    private function map(Permission $permission): array
    {
        return [
            'id' => $permission->getId(),
            'name' => $permission->getName(),
            'code' => $permission->getCode(),
        ];
    }

    /**
     * Map list
     *
     * @param Collection $permissions
     * @return array
     */
    private function mapList(Collection $permissions, string $method = 'map'): array
    {
        return $permissions->map(function ($permission) use ($method) {
            return $this->$method($permission);
        })->toArray();
    }
}
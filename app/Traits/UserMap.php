<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use App\Models\User;
use App\Traits\GroupMap;

trait UserMap
{
    use GroupMap {
        mapList as groupMapList;
        map as groupMap;
    }

    /**
     * Map for user model
     *
     * @param User $user
     * @return array
     */
    private function map(User $user): array
    {
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'groups' => $this->groupMapList($user->groups, 'groupMap'),
        ];
    }

    /**
     * Map list
     *
     * @param Collection $users
     * @return array
     */
    private function mapList(Collection $users, string $method = 'map'): array
    {
        return $users->map(function ($user) use ($method) {
            return $this->$method($user);
        })->toArray();
    }
}
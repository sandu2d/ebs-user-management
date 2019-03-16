<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use App\Traits\ControllerHelper;
use App\Http\Requests\Group\GetAllRequest;
use App\Http\Requests\Group\CreateRequest;
use App\Http\Requests\Group\GetByIdRequest;
use App\Http\Requests\Group\UpdateRequest;
use App\Http\Requests\Group\DeleteRequest;
use App\Http\Requests\Group\SyncPermissionsRequest;
use App\Traits\GroupMap;
use App\Models\Group;

class GroupController extends Controller
{
    use ControllerHelper,
        GroupMap;

    /**
     * Groups list
     *
     * @return mixed
     */
    public function getAllGroups(GetAllRequest $request)
    {
        return $this->json(
            $this->mapList(Group::all())
        );
    }

    /**
     * Create a group
     *
     * @param CreateRequest $request
     * @return mixed
     */
    public function create(CreateRequest $request)
    {
        $group = new Group([
            'name' => $request->group['name'],
        ]);

        $group->save();

        return $this->json(
            $this->map($group), 201
        );
    }

    /**
     * Get group by id
     *
     * @param GetByIdRequest $request
     * @param string $encodedGroupId
     * @return mixed
     */
    public function getById(GetByIdRequest $request, string $encodedGroupId)
    {
        if ($group = Group::findOrFail($encodedGroupId)) {
            return $this->json(
                $this->map($group)
            );
        }
    }

    /**
     * Update the group by id
     *
     * @param UpdateRequest $request
     * @param string $encodedGroupId
     * @return mixed
     */
    public function update(UpdateRequest $request, string $encodedGroupId)
    {
        if ($group = Group::findOrFail($encodedGroupId)) {
            $group->setName($request->group['name'] ?? $group->name);

            $group->save();

            return $this->json(
                $this->map($group)
            );
        }
    }

    /**
     * Delete a group
     *
     * @param DeleteRequest $request
     * @param string $encodedGroupId
     * @return mixed
     */
    public function delete(DeleteRequest $request, string $encodedGroupId)
    {
        if ($group = Group::findOrFail($encodedGroupId)) {
            $group->users()->detach();
            $group->permissions()->detach();
            $group->delete();

            return $this->json([], 200);
        }
    }

    /**
     * Sync the group`s permissions
     *
     * @param SyncPermissionsRequest $request
     * @param string $encodedGroupId
     * @return mixed
     */
    public function syncPermissions(SyncPermissionsRequest $request, string $encodedGroupId)
    {
        if ($group = Group::findOrFail($encodedGroupId)) {
            $group->permissions()->sync($request->group['permissions']);

            return $this->json([], 200);
        }
    }
}
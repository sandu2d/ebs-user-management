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
     * Users list
     *
     * @return mixed
     */
    public function getAllGroups(GetAllRequest $request)
    {
        return $this->json(
            $this->mapList(Group::all())
        );
    }

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

    public function getById(GetByIdRequest $request, string $encodedGroupId)
    {
        if ($group = Group::findOrFail($encodedGroupId)) {
            return $this->json(
                $this->map($group)
            );
        }
    }

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

    public function delete(DeleteRequest $request, string $encodedGroupId)
    {
        if ($group = Group::findOrFail($encodedGroupId)) {
            $group->users()->detach();
            $group->permissions()->detach();
            $group->delete();

            return $this->json([], 200);
        }
    }

    public function syncPermissions(SyncPermissionsRequest $request, string $encodedGroupId)
    {
        if ($group = Group::findOrFail($encodedGroupId)) {
            $group->permissions()->sync($request->group['permissions']);

            return $this->json([], 200);
        }
    }
}
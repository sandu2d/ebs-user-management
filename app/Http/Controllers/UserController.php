<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use App\Models\User;
use App\Traits\UserMap;
use App\Traits\ControllerHelper;
use App\Http\Requests\Users\CreateRequest;
use App\Http\Requests\Users\GetByIdRequest;
use App\Http\Requests\Users\UpdateRequest;
use App\Http\Requests\Users\DeleteRequest;
use App\Http\Requests\Users\ManageUserGroupRequest;
use Illuminate\Support\Facades\Crypt;
use App\Models\Group;

class UserController extends Controller
{
    use UserMap,
        ControllerHelper;

    /**
     * Users list
     *
     * @return mixed
     */
    public function getAllUsers()
    {
        return $this->json(
            $this->mapList(User::all())
        );
    }

    /**
     * Create a user
     *
     * @param CreateRequest $request
     * @return mixed
     */
    public function create(CreateRequest $request)
    {
        $user = new User([
            'name' => $request->user['name'],
            'email' => $request->user['email'],
            'password' => Crypt::encrypt($request->user['password']),
        ]);

        $user->save();

        return $this->json(
            $this->map($user), 201
        );
    }

    /**
     * Get user details by id
     *
     * @param GetByIdRequest $request
     * @param string $encodedUserId
     * @return mixed
     */
    public function getUserById(GetByIdRequest $request, string $encodedUserId)
    {
        if ($user = User::findOrFail($encodedUserId)) {
            return $this->json(
                $this->map($user)
            );
        }
    }

    /**
     * Update user
     *
     * @param UpdateRequest $request
     * @param string $encodedUserId
     * @return mixed
     */
    public function update(UpdateRequest $request, string $encodedUserId)
    {
        if ($user = User::findOrFail($encodedUserId)) {
            $user->setName($request->user['name'] ?? $user->name);
            $user->setEmail($request->user['email'] ?? $user->email);

            $user->save();

            return $this->json(
                $this->map($user)
            );
        }
    }

    /**
     * Delete the user
     *
     * @param DeleteRequest $request
     * @param string $encodedUserId
     * @return mixed
     */
    public function delete(DeleteRequest $request, string $encodedUserId)
    {
        if ($user = User::findOrFail($encodedUserId)) {
            $user->groups()->detach();
            $user->delete();

            return $this->json([], 200);
        }
    }

    /**
     * Add a group to user
     *
     * @param ManageUserGroupRequest $request
     * @param string $encodedUserId
     * @param string $encodedGroupId
     * @return mixed
     */
    public function addToGroup(
        ManageUserGroupRequest $request,
        string $encodedUserId,
        string $encodedGroupId
    ) {
        if ($user = User::findOrFail($encodedUserId)) {
            if ($group = Group::findOrFail($encodedGroupId)) {
                $user->groups()->sync($group->getId(), false);
    
                return $this->json([], 200);
            }
        }
    }

    /**
     * Remove a group from user
     *
     * @param ManageUserGroupRequest $request
     * @param string $encodedUserId
     * @param string $encodedGroupId
     * @return mixed
     */
    public function removeFromGroup(
        ManageUserGroupRequest $request,
        string $encodedUserId,
        string $encodedGroupId
    ) {
        if ($user = User::findOrFail($encodedUserId)) {
            if ($group = Group::findOrFail($encodedGroupId)) {
                $user->groups()->detach($group->getId());
    
                return $this->json([], 200);
            }
        }
    }
}
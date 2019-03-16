<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use App\Traits\ControllerHelper;
use App\Models\Permission;
use App\Traits\PermissionMap;
use App\Http\Requests\Permission\GetAllRequest;

class PermisionController extends Controller
{
    use ControllerHelper,
        PermissionMap;

    /**
     * Permissions list
     *
     * @return mixed
     */
    public function getAllPermissions(GetAllRequest $request)
    {
        return $this->json(
            $this->mapList(Permission::all())
        );
    }
}
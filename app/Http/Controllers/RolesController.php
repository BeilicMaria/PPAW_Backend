<?php

namespace App\Http\Controllers;

use App\Http\Entities\RoleEntity;
use App\Http\Services\RoleService;
use App\Models\Role;
use App\Utils\ErrorAndSuccessMessages;
use App\Utils\HttpStatusCode;
use Exception;
use Illuminate\Http\Request;
use \Response;
use Illuminate\Support\Facades\Log;


class RolesController extends Controller
{
    /**
     * roleRepo
     *
     * @var mixed
     */
    protected $roleRepo;

    /**
     * __construct
     *
     * @param  mixed $role
     * @return void
     */
    function __construct(RoleService $role)
    {
        $this->roleRepo = $role;
    }

    /**
     * getIndex get all roles
     *
     * @return void
     */
    public function index()
    {
        try {
            $roles = array();
            $dbRoles = $this->roleRepo->all();
            foreach ($dbRoles as $role) {
                $newRole = new RoleEntity($role);
                array_push($roles, $newRole);
            }
            if (!isset($roles))
                return Response::make(ErrorAndSuccessMessages::getDataFailed, HttpStatusCode::BadRequest);
            return Response::json([['roles' => $roles]], HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e);
        }
    }

    /**
     * get role by id
     *
     * @param  mixed $id
     * @return void
     */
    public function get($id)
    {
        try {
            $role = $this->roleRepo->find($id);
            $newRole = new RoleEntity($role);
            if (!isset($newRole))
                return Response::make(ErrorAndSuccessMessages::getDataFailed, HttpStatusCode::BadRequest);
            return Response::json(['role' => $newRole], HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e);
            return Response::json($e, HttpStatusCode::BadRequest);
        }
    }
}

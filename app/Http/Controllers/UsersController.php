<?php

namespace App\Http\Controllers;

use App\Http\Entities\UserEntity;
use App\Http\Services\UserService;
use App\Models\User;
use App\Utils\ErrorAndSuccessMessages;
use App\Utils\HttpStatusCode;
use Exception;
use DB;
use \Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class UsersController extends Controller
{

    /**
     * useService
     *
     * @var mixed
     */
    protected $useService;

    /**
     * __construct
     *
     * @param  mixed $user
     * @return void
     */
    function __construct(UserService $user)
    {
        $this->useService = $user;
    }


    /**
     * index
     *
     * @param  mixed $page
     * @param  mixed $per_page
     * @param  mixed $sort
     * @param  mixed $order
     * @param  mixed $filter
     * @return void
     */
    public function index($page = null, $per_page = null, $sort = null, $order = null, $filter = null)
    {
        try {
            if (!isset($page) && !isset($per_pag)) {
                $page = 1;
                $per_page = 20;
            }
            $DBusers = $this->useService->getWithRelationship('role');
            $users = array();

            foreach ($DBusers as $user) {
                $newUser = new UserEntity($user);
                array_push($users, $newUser);
            }
            return Response::json([["items" => $users]], HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            return Response::json($e->getMessage(), HttpStatusCode::BadRequest);
        }
    }


    /**
     * get a user by id
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        try {
            $user = User::with(["role" => function ($query) {
                $query->select('id', 'role');
            }, "address" => function ($query) {
                $query->select('id', 'country', 'county', 'city', 'address');
            }])->find($id);
            if (!isset($user))
                return Response::make(ErrorAndSuccessMessages::getDataFailed, HttpStatusCode::BadRequest);
            return Response::json(["user" => $user], HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e);
            return Response::json($e, HttpStatusCode::BadRequest);
        }
    }
}

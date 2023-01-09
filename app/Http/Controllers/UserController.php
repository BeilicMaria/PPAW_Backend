<?php

namespace App\Http\Controllers;

use App\Http\Entities\UserEntity;
use App\Http\Services\UserService;
use App\Utils\ErrorAndSuccessMessages;
use App\Utils\HttpStatusCode;
use Exception;
use \Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class UserController extends Controller
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
     * index: get all users
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
            $users = array();
            //replace with automapper
            list($dbUsers, $count) = $this->useService->getAll($page, $per_page, $sort, $order, $filter);
            foreach ($dbUsers as $user) {
                $dtoUser = new UserEntity($user);
                array_push($users, $dtoUser);
            }
            return Response::json(["total_count" => $count, "users" => $users], HttpStatusCode::OK);
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
            $user = $this->useService->get($id);
            if (!isset($user))
                return Response::make(ErrorAndSuccessMessages::getDataFailed, HttpStatusCode::BadRequest);
            //replace with automapper
            $dtoUser = new UserEntity($user);
            return Response::json(["user" => $dtoUser], HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e);
            return Response::json($e, HttpStatusCode::BadRequest);
        }
    }


    /**
     * post: create new user
     *
     * @param  mixed $request
     * @return void
     */
    public function post(Request $request)
    {
        try {
            $user = $this->useService->createUser($request);
            if (!isset($user))
                return Response::make(ErrorAndSuccessMessages::validationError, HttpStatusCode::BadRequest);
            return Response::make(ErrorAndSuccessMessages::successRegistration, HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e);
            return Response::json($e, HttpStatusCode::BadRequest);
        }
    }



    /**
     * put: update user
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function put(Request $request)
    {
        try {
            $id = $request->input('id');
            if (!isset($id)) {
                return Response::make(ErrorAndSuccessMessages::incompleteInput, HttpStatusCode::BadRequest);
            }
            $updatedUser = $this->useService->updateUser($request, $id);
            if (!isset($updatedUser))
                return Response::make(ErrorAndSuccessMessages::validationError, HttpStatusCode::BadRequest);
            return Response::json(["user" => $updatedUser], HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e);
            return Response::json($e, HttpStatusCode::BadRequest);
        }
    }

    /**
     * delete: soft delete user
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id)
    {
        try {
            if (!isset($id)) {
                return Response::make(ErrorAndSuccessMessages::incompleteInput, HttpStatusCode::BadRequest);
            }
            $deletedUser = $this->useService->softDelete($id);
            if (!isset($deletedUser))
                return Response::make(ErrorAndSuccessMessages::validationError, HttpStatusCode::BadRequest);
            return Response::json(["user" => $deletedUser], HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e);
            return Response::json($e, HttpStatusCode::BadRequest);
        }
    }
}

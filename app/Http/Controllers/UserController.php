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
    public function index($page = null, $per_page = null, $startDate = null, $endDate = null, $order = null, $status = null, $filter = null)
    {
        try {
            $users = array();
            //replace with automapper
            list($dbUsers, $count) = $this->useService->getAll($page, $per_page, $startDate, $endDate, $order, $status, $filter);
            foreach ($dbUsers as $user) {
                $dtoUser = new UserEntity($user);
                array_push($users, $dtoUser);
            }
            Log::debug("S-au returnat toti utilizatorii.");
            return Response::json(["total_count" => $count, "users" => $users], HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            return Response::make(ErrorAndSuccessMessages::genericServerError, HttpStatusCode::BadRequest);
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
            Log::debug("S-a returnat un utilizator.");
            return Response::json(["user" => $dtoUser], HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e);
            return Response::make(ErrorAndSuccessMessages::genericServerError, HttpStatusCode::BadRequest);
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
            $alreadyUsedName = $this->useService->checkIfUserExists('userName', $request->input('userName'));
            if ($alreadyUsedName) return Response::make(ErrorAndSuccessMessages::alreadyUsedName, HttpStatusCode::BadRequest);
            $alreadyUsedEmail = $this->useService->checkIfUserExists('email', $request->input('email'));
            if ($alreadyUsedEmail) return Response::make(ErrorAndSuccessMessages::alreadyUsedEmail, HttpStatusCode::BadRequest);
            $user = $this->useService->createUser($request);
            if (!isset($user))
                return Response::make(ErrorAndSuccessMessages::validationError, HttpStatusCode::BadRequest);
            Log::debug("Operatia de adaugare a unui utilizator s-a efectuat cu succes.");
            return Response::make(ErrorAndSuccessMessages::successRegistration, HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e);
            return Response::make(ErrorAndSuccessMessages::genericServerError, HttpStatusCode::BadRequest);
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
            Log::debug("Actualizarea utilizatorului s-a efectuat cu succes.");
            return Response::json(["user" => $updatedUser], HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e);
            return Response::make(ErrorAndSuccessMessages::genericServerError, HttpStatusCode::BadRequest);
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
            Log::debug("Stergere (logica) a utilizator s-a efectuat cu succes.");
            return Response::json(["user" => $deletedUser], HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e);
            return Response::make(ErrorAndSuccessMessages::genericServerError, HttpStatusCode::BadRequest);
        }
    }
}

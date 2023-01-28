<?php

namespace App\Http\Services;

use App\Http\Repositories\Repository;
use App\Http\Services\Cache\MemoryCacheService;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Container\Container as App;
use Illuminate\Http\Request;

class UserService extends Repository
{

    /**
     * cache
     *
     * @var mixed
     */
    private $cache;

    /**
     * __construct
     *
     * @param  mixed $app
     * @return void
     */
    public function __construct(App $app, MemoryCacheService $cache)
    {
        parent::__construct($app);
        $this->cache = $cache;
    }


    /**
     * specify model class name
     * @ return mixed
     */
    public function model()
    {
        return '\App\Models\User';
    }

    /**
     * get user by id
     *
     * @param  mixed $id
     * @return void
     */
    public function get($id)
    {
        // $cacheUser = $this->cache->get($id, 'user');
        // if (isset($cacheUser)) {
        //     return $cacheUser;
        // }
        $user = User::with(["role" => function ($query) {
            $query->select('id', 'role');
        },])->find($id);
        // $this->cache->set($id, $user, ['user']);
        return $user;
    }



    /**
     * getAll: get all users with pagination
     *
     * @param  mixed $page
     * @param  mixed $per_page
     * @param  mixed $sort
     * @param  mixed $order
     * @param  mixed $filter
     * @return void
     */
    public function getAll($page, $per_page, $startDate, $endDate, $order, $status, $filter)
    {
        // if ($this->cache->isSet('users')) {
        //     $item = $this->cache->get('users');
        //     return [$item, count($item)];
        // } else {
        if (!isset($page) && !isset($per_pag)) {
            $page = 1;
            $per_page = 20;
        }
        $users = User::with(["role" => function ($query) {
            $query->select('id', 'role');
        },])->skip($per_page * ($page - 1))->take($per_page);

        if (isset($filter) && $filter != "" && $filter != "null") {
            $users->where('lastName', 'like', "%" . $filter . "%")->orWhere('firstName', 'like', "%" . $filter . "%");
        }
        if (isset($startDate) && $startDate !== 'null' && isset($endDate) && $endDate !== 'null') {
            $users->whereBetween('created_at', [$startDate, $endDate]);
        }
        if (isset($status) && $status !== 'null') {
            $users->where('status', '=', filter_var($status, FILTER_VALIDATE_BOOLEAN));
        }
        $users->where('Fk_roleId', '!=', 1);
        $count = $users->count();
        if (isset($sort) && isset($order) && $order !== "null")
            $users->orderBy("created_at", $order);
        else {
            $users->orderBy("created_at", "desc");
        }
        $users = $users->get();
        // $item = $this->cache->set('users', $users);
        return [$users, $count];
        // }
    }


    /**
     * createUser: create new user
     *
     * @param  mixed $request
     * @return void
     */
    public function createUser(Request $request)
    {
        if ($this->cache->isSet('users')) {
            $this->cache->remove('users');
        }
        $validator = Validator::make($request->all(), [
            'userName' => 'required|string|max:55|unique:users',
            'lastName' => 'required|string|max:55',
            'firstName' => 'required|string|max:55',
            'email' => 'email|required|E-Mail|unique:users',
            'password' => 'required|confirmed',
            'phone' => 'required|numeric|digits:10',
            'dateOfBirth' => 'required',
            'status' => 'required|boolean',
            'FK_roleId' => 'required',
        ]);
        if ($validator->fails()) {
            return null;
        }
        $date = date_create($request->input('dateOfBirth'));
        $data = $request->all();
        $data['dateOfBirth'] = date_format($date, "Y-m-d");
        $data['password'] = bcrypt($request->password);
        $user = $this->create($data);
        return $user;
    }

    /**
     * updateUser: update user
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function updateUser($request, $id)
    {
        if ($this->cache->isSet($id)) {
            $this->cache->remove($id);
            $this->cache->remove('users');
        }
        $date = date_create($request->input('dateOfBirth'));
        $user = $this->find($id);
        $user->userName = $request->input('userName');
        $user->lastName = $request->input('lastName');
        $user->firstName = $request->input('firstName');
        $user->password = bcrypt($request->input('password'));
        $user->phone = $request->input('phone');
        $user->dateOfBirth = date_format($date, "Y-m-d");
        $user->FK_roleId = $request->input('FK_roleId');
        $user->save();
        return $user;
    }


    /**
     * softDelete
     *
     * @param  mixed $id
     * @return void
     */
    public function softDelete($id)
    {
        $this->cache->remove($id);
        $this->cache->remove('users');
        $user = $this->find($id);
        $user->status = false;
        $user->save();
        return $user;
    }



    /**
     * checkIfUserExists
     *
     * @param  mixed $property
     * @param  mixed $userName
     * @return void
     */
    public function checkIfUserExists($property, $userName)
    {
        try {
            $user = $this->findBy($property, $userName);
            if (isset($user)) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            Log::debug($e);
            return true;
        }
    }
}

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
     * get
     *
     * @param  mixed $id
     * @return void
     */
    public function get($id)
    {

        $cacheUser = $this->cache->get($id, 'user');
        if (isset($cacheUser)) {
            return $cacheUser;
        }
        $user = User::with(["role" => function ($query) {
            $query->select('id', 'role');
        },])->where('status', true)->find($id);
        $item = $this->cache->set($id, $user, ['user']);
        return $user;
    }



    /**
     * getAll
     *
     * @param  mixed $page
     * @param  mixed $per_page
     * @param  mixed $sort
     * @param  mixed $order
     * @param  mixed $filter
     * @return void
     */
    public function getAll($page, $per_page, $sort, $order, $filter)
    {
        if ($this->cache->isSet('users')) {
            $item = $this->cache->get('users');
            return [$item, count($item)];
        } else {
            if (!isset($page) && !isset($per_pag)) {
                $page = 1;
                $per_page = 20;
            }
            $users = User::with(["role" => function ($query) {
                $query->select('id', 'role');
            },])->skip($per_page * ($page - 1))->take($per_page);

            if (isset($filter) && $filter != "" && $filter != "null") {
                $users->where('name', 'like', "%" . $filter . "%");
            }
            $users->where('status', '=', true);
            $count = $users->count();
            if (isset($sort) && isset($order) && $order !== "null")
                $users->orderBy($sort, $order);
            else {
                $users->orderBy("id", "desc");
            }
            $users = $users->get();
            $item = $this->cache->set('users', $users);
            return [$users, $count];
        }
    }


    /**
     * createUser
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
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $user = $this->create($data);
        return $user;
    }

    /**
     * updateUser
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
        $user = $this->find($id);
        $user->userName = $request->input('userName');
        $user->lastName = $request->input('lastName');
        $user->firstName = $request->input('firstName');
        $user->password = bcrypt($request->input('password'));
        $user->phone = $request->input('phone');
        $user->dateOfBirth = $request->input('dateOfBirth');
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
}

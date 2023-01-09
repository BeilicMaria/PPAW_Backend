<?php

namespace App\Http\Services;

use App\Http\Repositories\Repository;
use App\Http\Services\Cache\MemoryCacheService;
use Illuminate\Container\Container as App;

class RoleService extends Repository
{

    private $cache;
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
        return '\App\Models\Role';
    }

    /**
     * getAll: get all roles
     *
     * @return void
     */
    public function getAll()
    {
        if ($this->cache->isSet('roles')) {
            $roles = $this->cache->get('roles');
            return $roles;
        } else {
            $roles = $this->all();
            $this->cache->set('roles', $roles);
            return  $roles;
        }
    }
}

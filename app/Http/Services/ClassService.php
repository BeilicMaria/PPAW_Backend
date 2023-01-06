<?php

namespace App\Http\Services;

use App\Http\Repositories\Repository;
use Illuminate\Container\Container as App;
use App\Http\Services\Cache\MemoryCacheService;

class ClassService extends Repository
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
        return '\App\Models\SchoolClass';
    }


}

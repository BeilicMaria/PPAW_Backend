<?php

namespace App\Http\Services;

use App\Http\Repositories\Repository;
use Illuminate\Container\Container as App;
use App\Http\Services\Cache\MemoryCacheService;


class GradeService extends Repository
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
        return '\App\Models\Grade';
    }

    /**
     * hardDelete
     *
     * @param  mixed $id
     * @return void
     */
    public function hardDelete($id)
    {
        $this->cache->remove($id);
        $this->cache->remove('grades');
        $grade = $this->delete($id);
        return $grade;
    }
}

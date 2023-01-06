<?php

namespace App\Http\Services;

use App\Http\Repositories\Repository;
use Illuminate\Container\Container as App;
use App\Http\Services\Cache\MemoryCacheService;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Validator;

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

    /**
     * get
     *
     * @param  mixed $id
     * @return void
     */
    public function get($id)
    {
        $cachedClass = $this->cache->get($id, 'class');
        if (isset($cachedClass)) {
            return $cachedClass;
        }
        $_class = SchoolClass::where('archived', false)->find($id);
        $this->cache->set($id, $_class, ['class']);
        return $_class;
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
        if ($this->cache->isSet('classes')) {
            $cachedClasses = $this->cache->get('classes');
            return [$cachedClasses, count($cachedClasses)];
        } else {
        }
    }

    /**
     * createClass
     *
     * @param  mixed $request
     * @return void
     */
    public function createClass(Request $request)
    {
        if ($this->cache->isSet('classes')) {
            $this->cache->remove('classes');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:55|unique:users',
            'schoolYear' => 'required|string|max:55',
            'archived' => 'required',
        ]);
        if ($validator->fails()) {
            return null;
        }
        $data = $request->all();
        $classes = $this->create($data);
        return $classes;
    }
}

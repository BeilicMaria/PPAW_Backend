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
    public function getAll($page, $per_page,  $filter)
    {
        if ($this->cache->isSet('classes')) {
            $cachedClasses = $this->cache->get('classes');
            return [$cachedClasses, count($cachedClasses)];
        } else {
            if (!isset($page) && !isset($per_pag)) {
                $page = 1;
                $per_page = 20;
            }
            $classes = SchoolClass::where('archived', '=', false)->skip($per_page * ($page - 1))->take($per_page);
            if (isset($filter) && $filter != "" && $filter != "null") {
                $classes->where('name', 'like', "%" . $filter . "%");
            }
            $count = $classes->count();
            $classes->orderBy("id", "desc");
            $classes = $classes->get();
            $this->cache->set('classes', $classes);
            return [$classes, $count];
        }
    }

    /**
     * createClass
     *
     * @param  mixed $request
     * @return void
     */
    public function createClass($request)
    {
        if ($this->cache->isSet('classes')) {
            $this->cache->remove('classes');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:55',
            'schoolYear' => 'required|string|max:55',
            'archived' => 'required',
        ]);
        if ($validator->fails()) {
            return null;
        }
        $data = $request->all();
        $_class = $this->create($data);
        return $_class;
    }

    /**
     * updateClass
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function updateClass($request, $id)
    {
        if ($this->cache->isSet($id)) {
            $this->cache->remove($id, 'class');
            $this->cache->remove('classes');
        }
        $_class = $this->find($id);
        $_class->name = $request->input('name');
        $_class->schoolYear = $request->input('schoolYear');
        $_class->archived = $request->input('archived');
        $_class->save();
        return $_class;
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
        $this->cache->remove('classes');
        $_class = $this->find($id);
        $_class->archived = true;
        $_class->save();
        return $_class;
    }
}

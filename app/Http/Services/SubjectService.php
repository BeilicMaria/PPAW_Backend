<?php

namespace App\Http\Services;

use App\Http\Repositories\Repository;
use App\Http\Services\Cache\MemoryCacheService;
use App\Models\Subject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Container\Container as App;

class SubjectService extends Repository
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
        return '\App\Models\Subject';
    }

    /**
     * get
     *
     * @param  mixed $id
     * @return void
     */
    public function get($id)
    {
        $cachedSubject = $this->cache->get($id, 'subject');
        if (isset($cachedSubject)) {
            return $cachedSubject;
        }
        $subject = $this->find($id);
        $this->cache->set($id, $subject, ['subject']);
        return $subject;
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
    public function getAll($page, $per_page, $filter)
    {
        if ($this->cache->isSet('subjects')) {
            $cachedSubjects = $this->cache->get('subjects');
            return [$cachedSubjects, count($cachedSubjects)];
        } else {
            if (!isset($page) && !isset($per_pag)) {
                $page = 1;
                $per_page = 20;
            }
            $subjects = Subject::skip($per_page * ($page - 1))->take($per_page);
            if (isset($filter) && $filter != "" && $filter != "null") {
                $subjects->where('name', 'like', "%" . $filter . "%");
            }
            $count = $subjects->count();
            $subjects->orderBy("id", "desc");
            $subjects->where('deleted', '=', false);
            $subjects = $subjects->get();
            $this->cache->set('subjects', $subjects);
            return [$subjects, $count];
        }
    }

    /**
     * createSubject
     *
     * @param  mixed $request
     * @return void
     */
    public function createSubject($request)
    {
        if ($this->cache->isSet('subjects')) {
            $this->cache->remove('subjects');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:55',
            'credits' => 'required|numeric',
            'isMandatory' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return null;
        }
        $data = $request->all();
        $subject = $this->create($data);
        return $subject;
    }

    /**
     * updateSubject
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function updateSubject($request, $id)
    {

        $this->cache->remove($id);
        $this->cache->clear();
        $subject = $this->find($id);
        $subject->name = $request->input('name');
        $subject->credits = $request->input('credits');
        $subject->isMandatory = $request->input('isMandatory');
        $subject->save();
        return $subject;
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
        $this->cache->remove('subjects');
        $subject = $this->find($id);
        $subject->deleted = true;
        $subject->save();
        return $subject;
    }
}

<?php

namespace App\Http\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use \Exception;

abstract class Repository implements IRepository
{

    /**
     * @var App
     */
    private $app;

    /**
     * @var model
     */
    protected $model;

    /**
     * @param App $app
     * @throws \RepositoryException
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract function model();

    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model)
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $model;
    }


    /**
     * all
     *
     * @param  mixed $columns
     * @return void
     */
    public function all($columns = array('*'))
    {
        return $this->model->get($columns);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 20, $page = 1)
    {
        return $this->model->skip($perPage * ($page - 1))->take($perPage);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute = "id")
    {
        return $this->model->where($attribute, '=', $id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }


    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id,  $relationships = null, $columns = array('*'))
    {
        $model = $this->model->find($id, $columns);
        if (!isset($model)) {
            throw new Exception("Repository - model not found!");
        }
        if (isset($relationships)) {
            return  $model->load($relationships);
        }
        return $model;
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }


    /**
     * getWithRelationship
     *
     * @param  mixed $relationships
     * @return void
     */
    public function getWithRelationship($relationships)
    {
        $all = $this->model->get(array('*'));
        return $all->load($relationships);
    }
}

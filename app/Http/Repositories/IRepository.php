<?php

namespace App\Http\Repositories;

interface IRepository
{
    /**
     * all
     *
     * @param  mixed $columns
     * @return void
     */
    public function all($columns = array('*'));

    /**
     * paginate
     *
     * @param  mixed $perPage
     * @param  mixed $page
     * @return void
     */
    public function paginate($perPage = 20, $page = 1);

    /**
     * create
     *
     * @param  mixed $data
     * @return void
     */
    public function create(array $data);

    /**
     * update
     *
     * @param  mixed $data
     * @param  mixed $id
     * @return void
     */
    public function update(array $data, $id);

    /**
     * delete
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id);

    /**
     * find
     *
     * @param  mixed $id
     * @param  mixed $relationships
     * @param  mixed $columns
     * @return void
     */
    public function find($id,  $relationships = null, $columns = array('*'));

    /**
     * findBy
     *
     * @param  mixed $field
     * @param  mixed $value
     * @param  mixed $columns
     * @return void
     */
    public function findBy($field, $value, $columns = array('*'));

    /**
     * getWithRelationship
     *
     * @param  mixed $relationships
     * @return void
     */
    public function getWithRelationship($relationships);
}

<?php

namespace App\Http\Repositories;

interface IRepository
{
    /**
     * all: get al the items
     *
     * @param  mixed $columns
     * @return void
     */
    public function all($columns = array('*'));

    /**
     * paginate: get only a number of items depending on page/perPage
     *
     * @param  mixed $perPage
     * @param  mixed $page
     * @return void
     */
    public function paginate($perPage = 20, $page = 1);

    /**
     * create: create new item
     *
     * @param  mixed $data
     * @return void
     */
    public function create(array $data);

    /**
     * update: update item
     *
     * @param  mixed $data
     * @param  mixed $id
     * @return void
     */
    public function update(array $data, $id);

    /**
     * delete: delete item
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id);

    /**
     * find: find item by id
     *
     * @param  mixed $id
     * @param  mixed $relationships
     * @param  mixed $columns
     * @return void
     */
    public function find($id,  $relationships = null, $columns = array('*'));

    /**
     * findBy: find item by attribute
     *
     * @param  mixed $field
     * @param  mixed $value
     * @param  mixed $columns
     * @return void
     */
    public function findBy($field, $value, $columns = array('*'));

    /**
     * getWithRelationship: get item with Eloquent: Relationships
     *
     * @param  mixed $relationships
     * @return void
     */
    public function getWithRelationship($relationships);
}

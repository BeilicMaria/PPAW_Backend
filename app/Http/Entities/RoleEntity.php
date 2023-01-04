<?php

namespace App\Http\Entities;

class RoleEntity
{
    public $role;
    public $id;


    /**
     * __construct
     *
     * @param  mixed $role
     * @return void
     */
    function __construct($role)
    {
        $this->role = $role->role;
        $this->id = $role->id;
    }
}

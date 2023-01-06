<?php

namespace App\Http\Entities;

class RoleEntity
{
    public $id;
    public $role;



    /**
     * __construct
     *
     * @param  mixed $role
     * @return void
     */
    function __construct($role)
    {
        $this->id = $role->id;
        $this->role = $role->role;
    }
}

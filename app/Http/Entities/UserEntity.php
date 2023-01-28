<?php

namespace App\Http\Entities;

class UserEntity
{
    public $id;
    public $userName;
    public $lastName;
    public $firstName;
    public $email;
    public $phone;
    public $dateOfBirth;
    public $status;
    public $role;
    public $FK_roleId;


    /**
     * __construct
     *
     * @param  mixed $user
     * @return void
     */
    function __construct($user)
    {
        $this->id = $user->id;
        $this->userName = $user->userName;
        $this->lastName = $user->lastName;
        $this->firstName = $user->firstName;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->dateOfBirth = $user->dateOfBirth;
        $this->status = $user->status;
        $this->role = $user->role->role;
        $this->FK_roleId = $user->FK_roleId;
    }
}

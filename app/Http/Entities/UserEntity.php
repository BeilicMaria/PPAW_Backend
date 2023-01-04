<?php

namespace App\Http\Entities;
class UserEntity
{
    public $userName;
    public $lastName;
    public $firstName;
    public $email;
    public $password;
    public $phone;
    public $dateOfBirth;
    public $status;
    public $role;


    /**
     * __construct
     *
     * @param  mixed $user
     * @return void
     */
    function __construct($user)
    {
        $this->userName = $user->userName;
        $this->lastName = $user->lastName;
        $this->firstName = $user->firstName;
        $this->email = $user->email;
        $this->password = $user->password;
        $this->phone = $user->phone;
        $this->dateOfBirth = $user->dateOfBirth;
        $this->status = $user->status;
        $this->role = $user->role['role'];
    }
}

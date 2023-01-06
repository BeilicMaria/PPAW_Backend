<?php

namespace App\Http\Entities;

class ClassEntity
{

    public $id;
    public $name;
    public $schoolYear;
    public $archived;


    /**
     * __construct
     *
     * @param  mixed $schoolClass
     * @return void
     */
    function __construct($schoolClass)
    {
        $this->id = $schoolClass->id;
        $this->name = $schoolClass->name;
        $this->schoolYear = $schoolClass->schoolYear;
        $this->archived = $schoolClass->archived;
    }
}

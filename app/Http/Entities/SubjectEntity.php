<?php

namespace App\Http\Entities;

class SubjectEntity
{

    public $id;
    public $name;
    public $credits;
    public $isMandatory;
    public $deleted;



    /**
     * __construct
     *
     * @param  mixed $subject
     * @return void
     */
    function __construct($subject)
    {
        $this->id = $subject->id;
        $this->name = $subject->name;
        $this->credits = $subject->credits;
        $this->isMandatory = $subject->isMandatory;
        $this->deleted = $subject->deleted;
    }
}

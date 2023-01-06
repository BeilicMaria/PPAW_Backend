<?php

namespace App\Http\Entities;

class GradeEntity
{

    public $id;
    public $grade;
    public $student;
    public $teacher;
    public $subject;




    /**
     * __construct
     *
     * @param  mixed $grade
     * @return void
     */
    function __construct($grade)
    {
        $this->id = $grade->id;
        $this->grade = $grade->grade;
        $this->student = $grade->student;
        $this->teacher = $grade->teacher;
        $this->subject = $grade->subject;
    }
}

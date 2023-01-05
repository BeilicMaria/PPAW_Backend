<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = "students";
    protected $primaryKey = ['FK_userId', 'FK_classId'];

    /* RELATIONSHIPS*/
    /**
     * Get the user associated with the student.
     */
    public function user()
    {
        return $this->hasOne(User::class, "id", "FK_userId");
    }

    /**
     * Get the class associated with the student.
     */
    public function class()
    {
        return $this->hasOne(SchoolClass::class, "id", "FK_classId");
    }
}

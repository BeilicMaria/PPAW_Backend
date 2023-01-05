<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = "courses";
    protected $primaryKey = ['FK_subjectId', 'FK_classId', 'FK_teacherId'];
    protected $fillable = [];

    /* RELATIONSHIPS*/

    /**
     * subject
     * Get the subject associated with the course.
     * @return void
     */
    public function subject()
    {
        return $this->hasOne(Subject::class, "id", "FK_subjectId");
    }


    /**
     * schoolClass
     * Get the class associated with the course.
     * @return void
     */
    public function schoolClass()
    {
        return $this->hasOne(SchoolClass::class, "id", "FK_classId");
    }


    /**
     * teacher
     * Get the teacher associated with the course.
     * @return void
     */
    public function teacher()
    {
        return $this->hasOne(User::class, "id", "FK_teacherId");
    }
}

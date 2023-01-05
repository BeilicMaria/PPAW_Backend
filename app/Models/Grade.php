<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $table = "grades";
    protected $primaryKey = 'id';
    protected $fillable = [
        'grade',
        'FK_studentId',
        'FK_teacherId',
        'FK_subjectId',
    ];

    /* RELATIONSHIPS*/

    /**
     * student
     *
     * Get the student associated with the grade.
     * @return void
     */
    public function student()
    {
        return $this->hasOne(User::class, "id", "FK_studentId");
    }

    /**
     * teacher
     * Get the teacher associated with the grade.
     * @return void
     */
    public function teacher()
    {
        return $this->hasOne(User::class, "id", "FK_teacherId");
    }

    /**
     * subject
     *  Get the subject associated with the grade.
     * @return void
     */
    public function subject()
    {
        return $this->hasOne(Subject::class, "id", "FK_subjectId");
    }
}

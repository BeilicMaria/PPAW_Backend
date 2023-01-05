<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = "classes";
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'schoolYear'
    ];

    /* RELATIONSHIPS*/

    /**
     * student
     * Get the student that owns the class.
     * @return void
     */
    public function student()
    {
        return $this->belongsTo(Student::class,  "FK_classId");
    }

    /**
     * course
     * Get the course that owns the class.
     * @return void
     */
    public function course()
    {
        return $this->belongsTo(Course::class,  "FK_classId");
    }
}

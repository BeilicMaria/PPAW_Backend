<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = "subjects";
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'credits',
        'isMandatory',
    ];

    /* RELATIONSHIPS*/
    /**
     * grade
     * Get the grade associated with the subject.
     * @return void
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class,  "FK_subjectId");
    }


      /**
     * course
     * Get the course that owns the subject.
     * @return void
     */
    public function course()
    {
        return $this->belongsTo(Course::class,  "FK_subjectId");
    }
}

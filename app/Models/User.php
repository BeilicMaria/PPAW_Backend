<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = "users";
    protected $primaryKey = 'id';



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userName',
        'lastName',
        'firstName',
        'email',
        'password',
        'phone',
        'dateOfBirth',
        'status',
        'FK_roleId'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * role
     *
     * Get the role associated with the user.
     * @return void
     */
    public function role()
    {
        return $this->hasOne(Role::class, "id", "FK_roleId");
    }

    /**
     * student
     * Get the student that owns the user.
     * @return void
     */
    public function student()
    {
        return $this->belongsTo(Student::class,  "FK_userId");
    }

    /**
     * grade
     * Get the grade that owns the student.
     * @return void
     */
    public function studentGrade()
    {
        return $this->belongsTo(Grade::class,  "FK_studentId");
    }

    /**
     * grade
     * Get the grade that owns the teacher.
     * @return void
     */
    public function teacherGrade()
    {
        return $this->belongsTo(Grade::class,  "FK_teacherId");
    }

    /**
     * course
     * Get the course that owns the teacher.
     * @return void
     */
    public function course()
    {
        return $this->belongsTo(Course::class,  "FK_teacherId");
    }
}

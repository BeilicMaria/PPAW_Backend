<?php

namespace App\Http\Controllers;

use App\Http\Services\SubjectService;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * subjectService
     *
     * @var mixed
     */
    protected $subjectService;

    /**
     * __construct
     *
     * @param  mixed $subject
     * @return void
     */
    function __construct(SubjectService $subject)
    {
        $this->subjectService = $subject;
    }
}

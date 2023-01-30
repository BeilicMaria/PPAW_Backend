<?php

namespace App\Http\Controllers;

use App\Http\Services\GradeService;
use Illuminate\Http\Request;
use Exception;
use \Response;
use App\Utils\ErrorAndSuccessMessages;
use App\Utils\HttpStatusCode;
use Illuminate\Support\Facades\Log;
class GradeController extends Controller
{


    /**
     * gradeService
     *
     * @var mixed
     */
    protected $gradeService;

    /**
     * __construct
     *
     * @param  mixed $subject
     * @return void
     */
    function __construct(GradeService $grade)
    {
        $this->gradeService = $grade;
    }

    /**
     * delete: hard delete grade
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id)
    {
        try {
            if (!isset($id)) {
                return Response::make(ErrorAndSuccessMessages::incompleteInput, HttpStatusCode::BadRequest);
            }
            $deletedGrade = $this->gradeService->hardDelete($id);
            if (!isset($deletedGrade))
                return Response::make(ErrorAndSuccessMessages::validationError, HttpStatusCode::BadRequest);
            Log::debug("Stergere  notei s-a efectuat cu succes.");
            return Response::json(["grade" => $deletedGrade], HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e);
            return Response::make(ErrorAndSuccessMessages::genericServerError, HttpStatusCode::BadRequest);
        }
    }
}

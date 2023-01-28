<?php

namespace App\Http\Controllers;

use App\Http\Entities\SubjectEntity;
use App\Http\Services\SubjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use \Response;
use App\Utils\ErrorAndSuccessMessages;
use App\Utils\HttpStatusCode;

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


    /**
     * index: get all subjects
     *
     * @param  mixed $page
     * @param  mixed $per_page
     * @param  mixed $sort
     * @param  mixed $order
     * @param  mixed $filter
     * @return void
     */
    public function index($page = null, $per_page = null,  $filter = null)
    {
        try {
            $subjects = array();
            //replace with automapper
            list($dbSubject, $count) = $this->subjectService->getAll($page, $per_page, $filter);
            foreach ($dbSubject as $subject) {
                $dtoSubject = new SubjectEntity($subject);
                array_push($subjects, $dtoSubject);
            }
            Log::debug("S-au returnat toate materiile.");
            return Response::json(["total_count" => $count, "subjects" => $subjects], HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            return Response::make(ErrorAndSuccessMessages::genericServerError, HttpStatusCode::BadRequest);
        }
    }


    /**
     * post: create new subject
     *
     * @param  mixed $request
     * @return void
     */
    public function post(Request $request)
    {
        try {
            $subject = $this->subjectService->createSubject($request);
            if (!isset($subject))
                return Response::make(ErrorAndSuccessMessages::addFail, HttpStatusCode::BadRequest);
            Log::debug("Operatia de adaugare a unei materii s-a efectuat cu succes.");
            return Response::make(ErrorAndSuccessMessages::addSucces, HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e);
            return Response::make(ErrorAndSuccessMessages::genericServerError, HttpStatusCode::BadRequest);
        }
    }

        /**
     * put: update subject
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function put(Request $request)
    {
        try {
            $id = $request->input('id');
            if (!isset($id)) {
                return Response::make(ErrorAndSuccessMessages::incompleteInput, HttpStatusCode::BadRequest);
            }
            $updatedSubject = $this->subjectService->updateSubject($request, $id);
            if (!isset($updatedSubject))
                return Response::make(ErrorAndSuccessMessages::validationError, HttpStatusCode::BadRequest);
            Log::debug("Actualizarea materiei s-a efectuat cu succes.");
            return Response::json(["subject" => $updatedSubject], HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e);
            return Response::make(ErrorAndSuccessMessages::genericServerError, HttpStatusCode::BadRequest);
        }
    }

    /**
     * get a subject by id
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        try {
            $subject = $this->subjectService->get($id);
            if (!isset($subject))
                return Response::make(ErrorAndSuccessMessages::getDataFailed, HttpStatusCode::BadRequest);
            //replace with automapper
            $dtoSubject = new SubjectEntity($subject);
            Log::debug("S-a returnat o materie.");
            return Response::json(["subject" => $dtoSubject], HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e);
            return Response::make(ErrorAndSuccessMessages::genericServerError, HttpStatusCode::BadRequest);
        }
    }


    /**
     * delete: soft delete subject
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
            $deletedSubject = $this->subjectService->softDelete($id);
            if (!isset($deletedSubject))
                return Response::make(ErrorAndSuccessMessages::validationError, HttpStatusCode::BadRequest);
            Log::debug("Stergere (logica) a materiei s-a efectuat cu succes.");
            return Response::json(["subject" => $deletedSubject], HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e);
            return Response::make(ErrorAndSuccessMessages::genericServerError, HttpStatusCode::BadRequest);
        }
    }
}

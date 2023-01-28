<?php

namespace App\Http\Controllers;

use App\Http\Entities\ClassEntity;
use App\Http\Services\ClassService;
use Exception;
use \Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Utils\ErrorAndSuccessMessages;
use App\Utils\HttpStatusCode;

class ClassController extends Controller
{
    /**
     * classService
     *
     * @var mixed
     */
    protected $classService;

    /**
     * __construct
     *
     * @param  mixed $_class
     * @return void
     */
    function __construct(ClassService $_class)
    {
        $this->classService = $_class;
    }

    /**
     * index: get all classes
     *
     * @param  mixed $page
     * @param  mixed $per_page
     * @param  mixed $sort
     * @param  mixed $order
     * @param  mixed $filter
     * @return void
     */
    public function index($page = null, $per_page = null, $filter = null)
    {
        try {
            $classes = array();
            list($dbClasses, $count) = $this->classService->getAll($page, $per_page, $filter);
            foreach ($dbClasses as $_class) {
                $newClass = new ClassEntity($_class);
                array_push($classes, $newClass);
            }
            return Response::json(["total_count" => $count, "classes" => $classes], HttpStatusCode::OK);
        } catch (Exception $e) {

            Log::debug($e->getMessage());
            return Response::make($e->getMessage(), HttpStatusCode::BadRequest);
        }
    }

    /**
     * get a class by id
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        try {
            $_class = $this->classService->get($id);
            if (!isset($_class))
                return Response::make(ErrorAndSuccessMessages::getDataFailed, HttpStatusCode::BadRequest);
            $newClass = new ClassEntity($_class);
            return Response::json(["class" => $newClass], HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e);
            return Response::make($e, HttpStatusCode::BadRequest);
        }
    }

    /**
     * post: create a new class
     *
     * @param  mixed $request
     * @return void
     */
    public function post(Request $request)
    {
        try {
            $newClass = $this->classService->createClass($request);
            if (!isset($newClass))
                return Response::make(ErrorAndSuccessMessages::validationError, HttpStatusCode::BadRequest);
            return Response::make(ErrorAndSuccessMessages::successRegistration, HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e);
            return Response::make($e, HttpStatusCode::BadRequest);
        }
    }

    /**
     * put:  update class
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
            $updatedClass = $this->classService->updateClass($request, $id);
            if (!isset($updatedClass))
                return Response::make(ErrorAndSuccessMessages::validationError, HttpStatusCode::BadRequest);
            return Response::json(["class" => $updatedClass], HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e);
            return Response::make($e, HttpStatusCode::BadRequest);
        }
    }

    /**
     * delete:  archive class
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
            $deletedClass = $this->classService->softDelete($id);
            if (!isset($deletedClass))
                return Response::make(ErrorAndSuccessMessages::validationError, HttpStatusCode::BadRequest);
            return Response::json(["class" => $deletedClass], HttpStatusCode::OK);
        } catch (Exception $e) {
            Log::debug($e);
            return Response::make($e, HttpStatusCode::BadRequest);
        }
    }
}

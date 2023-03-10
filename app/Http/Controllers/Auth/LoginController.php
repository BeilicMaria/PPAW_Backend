<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use App\Utils\ErrorAndSuccessMessages;
use Illuminate\Http\Request;
use App\Utils\HttpStatusCode;
use Exception;
use \Response;
use \Validator;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{

    /**
     * userRepo
     *
     * @var mixed
     */
    protected  $userRepo;

    /**
     * __construct
     *
     * @param  mixed $user
     * @return void
     */
    function __construct(UserService $user)
    {
        $this->userRepo = $user;
    }


    /**
     * login
     *
     * @param  mixed $request
     * @return void
     */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return response(['errors' => $validator->errors()->all()], HttpStatusCode::Unauthorized);
            }
            $data = [
                'email' => $request->email,
                'password' => $request->password
            ];
            if (auth()->attempt($data)) {
                $accessToken = auth()->user()->createToken('authToken')->accessToken;
                $user = $this->userRepo->findBy('email', $request->email);
                return response()->json(['user' => $user, 'access_token' => $accessToken], HttpStatusCode::OK);
            } else {
                return Response::make(ErrorAndSuccessMessages::loginFailed, HttpStatusCode::Unauthorized);
            }
        } catch (Exception $e) {
            Log::debug($e);
            return Response::make(ErrorAndSuccessMessages::loginFailed, HttpStatusCode::BadRequest);
        }
    }
}

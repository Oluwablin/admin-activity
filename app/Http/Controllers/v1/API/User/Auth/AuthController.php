<?php

namespace App\Http\Controllers\v1\API\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginFormRequest;
use App\Http\Requests\Auth\UserRegistrationFormRequest;
use App\Models\User;
use App\Oluwablin\OluwablinApp;
use App\Oluwablin\OluwablinAuthentication;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    use OluwablinApp;

    /**
     * Login endpoint
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(UserLoginFormRequest $request)
    {
        extract($request->validated());

        $user = OluwablinAuthentication::authenticate(new User, $email, $password);

        if (null === $user || empty($user)) {
            return $this->AppResponse('failed', 'The provided credentials are incorrect.', 401);
        }

        return $this->AppResponse('OK', 'Logged in successful', 200, new UserResource($user['data']), $user['token']);
    }

    /**
     * Register endpoint
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(UserRegistrationFormRequest $request)
    {
        $user = User::create($request->validated());

        $auth = new OluwablinAuthentication($user);

        $token = $auth->createToken();

        return $this->AppResponse('OK', 'Registration successful', 201, new UserResource($user), $token);
    }
}

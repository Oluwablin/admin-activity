<?php

namespace App\Http\Controllers\v1\API\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginFormRequest;
use App\Models\Admin;
use App\Oluwablin\OluwablinApp;
use App\Oluwablin\OluwablinAuthentication;
use Illuminate\Http\Request;
use App\Http\Resources\AdminResource;

class AuthController extends Controller
{
    use OluwablinApp;
    /**
     * Admin login form post
     *
     * @param AdminLoginFormRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(AdminLoginFormRequest $request)
    {
        extract($request->validated());

        $admin = OluwablinAuthentication::authenticate(new Admin(), $email, $password);

        if (null === $admin || empty($admin)) {
            return $this->AppResponse('failed', 'The provided credentials are incorrect.', 401,);
        }

        return $this->AppResponse('OK', 'Logged in successful', 200, new AdminResource($admin['data']), $admin['token']);
    }
}

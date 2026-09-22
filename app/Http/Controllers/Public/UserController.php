<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Http\Requests\UserLoginRequest;
use App\Services\PublicService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    protected PublicService $publicService;
    protected UserService $userService;
    public function __construct(
        PublicService $publicService,
        UserService $userService
    ) {
        $this->publicService = $publicService;
        $this->userService = $userService;
    }
    public function  login()
    {

        return view('frontend.auth.login');
    }
    public function signin(UserLoginRequest $request)
    {
        $loginCredentials = $request->validated();

        $authenciated = $this->userService->userAuth($loginCredentials);

        if (!$authenciated) {
            return redirect()
                ->intended(route('login'))
                ->with('success', "You have successfully logged in");
        }

        return  redirect(route('dashboard'))
            ->with('message', "Login successfully");
    }
    public function register()
    {
        return view('frontend.auth.register');
    }
    public function store(UserFormRequest $request)
    {

        $newUser =  $this->userService->store($request->validated());

        if (!$newUser->id) {
            return  redirect(route('profile.register'))
                ->with('status', false)
                ->with('message', "Registration failed, try again please");;
        }
        return  redirect(route('profile.login'))
            ->with('status', true)
            ->with('message', "Registration successfully");;
    }


    public function logout()
    {

        Session::flush();
        Auth::logout();

        return  redirect(route('login'));
    }
}

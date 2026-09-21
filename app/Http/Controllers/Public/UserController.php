<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function  login() {

    return view('frontend.auth.login');
    }
    public function signin() {}
    public function register() {
           return view('frontend.auth.register');
    }
    public function store() {}
}

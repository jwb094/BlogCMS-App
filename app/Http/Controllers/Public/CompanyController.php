<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    //
    public function contact()
    {
        return view('frontend.company_and_support.contact');
    }
}

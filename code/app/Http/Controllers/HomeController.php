<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function dashboard(){
        Session::put('menu_active','/');
        return view('dashboard');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //登陆
    public function index(){
        return view('mstore/login');
    }
    /*
     * 注册
     * */
    public function register(){
        return view('mstore/register');
    }
}

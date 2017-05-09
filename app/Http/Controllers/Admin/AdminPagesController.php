<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


class AdminPagesController extends Controller
{

    public function __construct()
    {
     //   $this->middleware('guest', ['except' => 'logout']);
    }

    public function dashboard(){

        return  view("admin.dashboard",[

        ]);
    }
}

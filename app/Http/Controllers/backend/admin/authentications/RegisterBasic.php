<?php

namespace App\Http\Controllers\backend\admin\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterBasic extends Controller
{
  public function index()
  {
    return view('backend.admin.content.authentications.auth-register-basic');
  }
}

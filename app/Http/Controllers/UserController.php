<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  function login(Request $request){
    $this->validate($request, [
      'email' => 'required',
      'password' => 'required'
    ]);

    $user = User::where(['email' => $request->email, 'password' => $request->password])->first();

    return $user;
  }

  function findAll(Request $request)
  {
    return User::all();
  }
}

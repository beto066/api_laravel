<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\Client\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class UserController extends Controller
{
  function login(LoginRequest $request)
  {
    $user = User::where(['email' => $request->email])->first();

    if (!Hash::check($request->password, $user->password)) {
      throw new UnprocessableEntityHttpException("Login invalido");
    }

    $reponse = $user->toArray();
    $reponse['token'] = $user->createToken('server:update')->plainTextToken;

    return $reponse;
  }

  function findAll(Request $request)
  {
    return User::all();
  }

  function create(CreateUserRequest $request)
  {
    return User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'remember_token' => "server:update"
    ]);
  }
}

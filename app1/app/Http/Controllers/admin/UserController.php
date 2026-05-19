<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function active_account($email){
      $user=User::where('email',$email)->first();

      $user->status=1;
      $user->update();
      return redirect('/login')->with('success','Active account successfully');
    }
}

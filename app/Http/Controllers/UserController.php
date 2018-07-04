<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    public function getAllUsers(){
        try{
        $users=User::where([])->get();
        if(!$users){
            return response()->json(['anyone user']);
        }
        return response()->json($users);
        }catch(\Exception $exception){
            return response()->json(['exception message'=>$exception->getMessage()],500);
        }
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 7/3/2018
 * Time: 1:38 PM
 */

namespace App\Http\Controllers;


use App\Admin;
use Illuminate\Http\Request;

class AuthController extends Controller
{
//    public function __construct()
//    {
//        $user = new Admin();
//        $user->username = 'Admin';
//        $user->password = 'Admin';
//        $user->save();
//    }

    public function login(Request $request){
            $admin = Admin::find(1);
            if($admin->username === $request->username && $admin->password === $request->password){
                $_SESSION['username'] = $request->username;
                return response()->json(['status'=>'success','message'=>'auth success']);
            }

            return response()->json(['status'=>'error','message'=>'auth failed']);
    }

    public function auth(){
        if(isset($_SESSION['username']))
            return response()->json(['status'=>'authenticated']);
        return response()->json(['status'=>'unauthenticated']);
    }

    public function logout(){
        unset($_SESSION['username']);
        return response()->json(['status'=>'logout']);
    }

    public function updatePassword(Request $request){
        $admin = Admin::find(1);
        $admin->password = $request->password;
        if($admin->save())
            return response()->json(['status'=>'success','message'=>'password updated']);
        return response()->json(['status'=>'error','message'=>'password not updated']);
    }


}
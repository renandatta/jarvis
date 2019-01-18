<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(){
        Session::forget('user_active');
        return view('login');
    }

    public function login_proses(Request $request){
        $user = User::where('email','=',$request->input('email'))->first();
        if(!empty($user)){
            if(decrypt($user->password) == $request->input('password')){
                $result = true;
                $ioController = new IoController();
                $ioController->save_user_log($user->id,$request->input('_token'),'login','login');
                Session::put('user_active',$user);
            }else{
                $result = false;
            }
        }else{
            $result = false;
        }

        if($result == true){
            $message['type'] = 'success';
            $message['content'] = "Welcome ".$user->nama;
            return redirect('/')
                ->with('message',$message);
        }else{
            $message['type'] = 'danger';
            $message['content'] = "Email and Password Doesn't exist";
            return redirect('login')
                ->with('message',$message);
        }
    }

    public function logout(){
        return redirect('login');
    }
}

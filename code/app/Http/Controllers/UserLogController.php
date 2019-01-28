<?php

namespace App\Http\Controllers;

use App\User;
use App\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserLogController extends Controller
{
    public function index($user_id = 'all', $search = 'all', $mode = null){
        Session::put('menu_active','user_log');
        $query = UserLog::select('*')->where('user_id','=',$user_id);
        $ioController = new IoController();
        $query = $ioController->search_tool($query,$search);
        if($mode == null) {
            $data = $query->paginate(10);
            $user = User::orderBy('fullname','asc')->get();
            return view('user_log.index')
                ->with('search', $search)
                ->with('data', $data)
                ->with('user_id', $user_id)
                ->with('user', $user);
        }else{
            return $query->get();
        }
    }

    public function search(Request $request){
        $search = '';
        if($request->input('user_id') != ''){
            $search .= $request->input('user_id').'/';
        }
        if($request->input('keyword') != ''){
            $search .= 'log'.',like,'.$request->input('keyword').';';
        }
        if($search != ''){
            $search = '/'.$search;
        }
        return redirect('user_log'.$search);
    }
}

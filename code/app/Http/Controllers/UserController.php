<?php

namespace App\Http\Controllers;

use App\User;
use App\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index($search = 'all', $mode = null){
        Session::put('menu_active','user');
        $query = User::select('*');
        $ioController = new IoController();
        $query = $ioController->search_tool($query,$search);
        if($mode == null) {
            $data = $query->paginate(10);
            return view('user.index')
                ->with('search', $search)
                ->with('data', $data);
        }else{
            return $query->get();
        }
    }

    public function search(Request $request){
        $search = '';
        if($request->input('keyword') != ''){
            $search .= 'fullname'.',like,'.$request->input('keyword').';';
        }
        if($search != ''){
            $search = '/'.$search;
        }
        return redirect('user'.$search);
    }

    public function info($id){
        $field = [];
        if($id != 'new'){
            $field = User::find($id);
        }
        $user_level = UserLevel::orderBy('user_level')->get();
        return view('user.info')
            ->with('id', $id)
            ->with('field', $field)
            ->with('user_level', $user_level);
    }

    public function save(Request $request, $id){
        if($id == 'new'){
            $field = User::create($request->all());
            $action = "added";
        }else{
            $field = User::find($id);
            $field->update($request->all());
            $action = "updated";
        }
        if($request->input('password') != ''){
            $field->password = encrypt($request->input('password'));
            $field->save();
        }
        $ioController = new IoController();
        $ioController->save_user_log(null,$request->input('_token'),$action,"users;".json_encode($field));
        $message['type'] = 'success';
        $message['content'] = "User Successfully ".ucwords($action);
        return redirect('user')
            ->with('message',$message);
    }

    public function delete(Request $request,$id){
        $field = User::find($id);
        try {
            $field->delete();
            $ioController = new IoController();
            $ioController->save_user_log(null,$request->input('_token'),"deleted","users;".json_encode($field));
            $message['type'] = 'success';
            $message['content'] = "User Successfully Deleted";
        } catch (\Exception $e) {
            $message['type'] = 'danger';
            $message['content'] = "User Cannot Deleted";
        }
        return redirect('user')
            ->with('message',$message);
    }
}

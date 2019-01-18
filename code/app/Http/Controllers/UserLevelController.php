<?php

namespace App\Http\Controllers;

use App\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserLevelController extends Controller
{
    public function index($search = 'all', $mode = null){
        Session::put('menu_active','user_level');
        $query = UserLevel::select('*');
        $ioController = new IoController();
        $query = $ioController->search_tool($query,$search);
        if($mode == null) {
            $data = $query->paginate(10);
            return view('user_level.index')
                ->with('search', $search)
                ->with('data', $data);
        }else{
            return $query->get();
        }
    }

    public function search(Request $request){
        $search = '';
        if($request->input('keyword') != ''){
            $search .= 'user_level'.',like,'.$request->input('keyword').';';
        }
        if($search != ''){
            $search = '/'.$search;
        }
        return redirect('user_level'.$search);
    }

    public function info($id){
        $field = [];
        if($id != 'new'){
            $field = UserLevel::find($id);
        }
        return view('user_level.info')
            ->with('id', $id)
            ->with('field', $field);
    }

    public function save(Request $request, $id){
        if($id == 'new'){
            $field = UserLevel::create($request->all());
            $action = "added";
        }else{
            $field = UserLevel::find($id);
            $field->update($request->all());
            $action = "updated";
        }
        $ioController = new IoController();
        $ioController->save_user_log(null,$request->input('_token'),$action,"user_levels;".json_encode($field));
        $message['type'] = 'success';
        $message['content'] = "User Level Successfully ".ucwords($action);
        return redirect('user_level')
            ->with('message',$message);
    }

    public function delete(Request $request,$id){
        $field = UserLevel::find($id);
        try {
            $field->delete();
            $ioController = new IoController();
            $ioController->save_user_log(null,$request->input('_token'),"deleted","user_levels;".json_encode($field));
            $message['type'] = 'success';
            $message['content'] = "User Level Successfully Deleted";
        } catch (\Exception $e) {
            $message['type'] = 'danger';
            $message['content'] = "User Level Cannot Deleted";
        }
        return redirect('user_level')
            ->with('message',$message);
    }
}

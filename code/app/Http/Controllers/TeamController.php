<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use App\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index($search = 'all', $mode = null){
        Session::put('menu_active','team');
        $query = Team::select('*');
        $ioController = new IoController();
        $query = $ioController->search_tool($query,$search);
        if($mode == null) {
            $data = $query->paginate(10);
            return view('team.index')
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
        return redirect('team'.$search);
    }

    public function info($id){
        $field = [];
        if($id != 'new'){
            $field = Team::find($id);
            $field->user = User::find($field->user_id);
        }
        $user_level = UserLevel::orderBy('user_level')->get();
        return view('team.info')
            ->with('id', $id)
            ->with('field', $field)
            ->with('user_level', $user_level);
    }

    public function save(Request $request, $id){
        if($id == 'new'){
            $user = User::create($request->all());
            $request->merge(['user_id' => $user->id]);
            $field = Team::create($request->all());
            $action = "added";
        }else{
            $field = Team::find($id);
            $field->update($request->all());

            $user = User::find($field->user_id);
            $user->update($request->all());
            $action = "updated";
        }
        if($request->input('password') != ''){
            $user->password = encrypt($request->input('password'));
            $field->save();
        }
        if($request->hasFile('photo')){
            if(($id != 'new') and (Storage::exists('photo/'.$field->image))){
                unlink(storage_path('app/photo/'.$field->image));
            }
            $filename = str_random(60).'.'.$request->file('photo')->extension();
            Storage::putFileAs('photo',$request->file('photo'),$filename);
            $field->photo = $filename;
            $field->save();
        }
        $ioController = new IoController();
        $ioController->save_user_log(null,$request->input('_token'),$action,"teams;".json_encode($field));
        $ioController->save_user_log(null,$request->input('_token'),$action,"users;".json_encode($user));
        $message['type'] = 'success';
        $message['content'] = "Team Successfully ".ucwords($action);
        return redirect('team')
            ->with('message',$message);
    }

    public function delete(Request $request,$id){
        $field = Team::find($id);
        $user = User::find($field->user_id);
        try {
            $field->delete();
            $user->delete();
            $ioController = new IoController();
            $ioController->save_user_log(null,$request->input('_token'),"deleted","teams;".json_encode($field));
            $ioController->save_user_log(null,$request->input('_token'),"deleted","users;".json_encode($user));
            $message['type'] = 'success';
            $message['content'] = "Team Successfully Deleted";
        } catch (\Exception $e) {
            $message['type'] = 'danger';
            $message['content'] = "Team Cannot Deleted";
        }
        return redirect('team')
            ->with('message',$message);
    }
}

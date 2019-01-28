<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocationController extends Controller
{
    public function index($search = 'all', $mode = null){
        Session::put('menu_active','location');
        $query = Location::select('*');
        $ioController = new IoController();
        $query = $ioController->search_tool($query,$search);
        if($mode == null) {
            $data = $query->paginate(10);
            return view('location.index')
                ->with('search', $search)
                ->with('data', $data);
        }else{
            return $query->get();
        }
    }

    public function search(Request $request){
        $search = '';
        if($request->input('keyword') != ''){
            $search .= 'location'.',like,'.$request->input('keyword').';';
        }
        if($search != ''){
            $search = '/'.$search;
        }
        return redirect('location'.$search);
    }

    public function info($id){
        $field = [];
        if($id != 'new'){
            $field = Location::find($id);
        }
        return view('location.info')
            ->with('id', $id)
            ->with('field', $field);
    }

    public function save(Request $request, $id){
        if($id == 'new'){
            $field = Location::create($request->all());
            $action = "added";
        }else{
            $field = Location::find($id);
            $field->update($request->all());
            $action = "updated";
        }
        $ioController = new IoController();
        $ioController->save_user_log(null,$request->input('_token'),$action,"user_levels;".json_encode($field));
        $message['type'] = 'success';
        $message['content'] = "User Level Successfully ".ucwords($action);
        return redirect('location')
            ->with('message',$message);
    }

    public function delete(Request $request,$id){
        $field = Location::find($id);
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
        return redirect('location')
            ->with('message',$message);
    }
}

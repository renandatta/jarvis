<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientType;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index($search = 'all', $mode = null){
        Session::put('menu_active','client');
        $query = Client::select('*');
        $ioController = new IoController();
        $query = $ioController->search_tool($query,$search);
        if($mode == null) {
            $data = $query->paginate(10);
            return view('client.index')
                ->with('search', $search)
                ->with('data', $data);
        }else{
            return $query->get();
        }
    }

    public function search(Request $request){
        $search = '';
        if($request->input('keyword') != ''){
            $search .= 'name'.',like,'.$request->input('keyword').';';
        }
        if($search != ''){
            $search = '/'.$search;
        }
        return redirect('client'.$search);
    }

    public function info($id){
        $field = [];
        if($id != 'new'){
            $field = Client::find($id);
        }
        $client_type = ClientType::orderBy('type','asc')->get();
        $location = Location::orderBy('location','asc')->get();
        return view('client.info')
            ->with('id', $id)
            ->with('field', $field)
            ->with('client_type', $client_type)
            ->with('location', $location);
    }

    public function save(Request $request, $id){
        if($id == 'new'){
            $field = Client::create($request->all());
            $action = "added";
        }else{
            $field = Client::find($id);
            $field->update($request->all());
            $action = "updated";
        }
        if($request->hasFile('logo')){
            if(($id != 'new') and (Storage::exists('logo/'.$field->logo))){
                unlink(storage_path('app/logo/'.$field->logo));
            }
            $filename = str_random(60).'.'.$request->file('logo')->extension();
            Storage::putFileAs('logo',$request->file('logo'),$filename);
            $field->logo = $filename;
            $field->save();
        }
        $ioController = new IoController();
        $ioController->save_user_log(null,$request->input('_token'),$action,"users;".json_encode($field));
        $message['type'] = 'success';
        $message['content'] = "Client Successfully ".ucwords($action);
        return redirect('client')
            ->with('message',$message);
    }

    public function delete(Request $request,$id){
        $field = Client::find($id);
        try {
            $field->delete();
            $ioController = new IoController();
            $ioController->save_user_log(null,$request->input('_token'),"deleted","users;".json_encode($field));
            $message['type'] = 'success';
            $message['content'] = "Client Successfully Deleted";
        } catch (\Exception $e) {
            $message['type'] = 'danger';
            $message['content'] = "Client Cannot Deleted";
        }
        return redirect('client')
            ->with('message',$message);
    }
}

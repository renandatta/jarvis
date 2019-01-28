<?php

namespace App\Http\Controllers;

use App\Client;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index($search = 'all', $mode = null){
        Session::put('menu_active','project');
        $query = Project::select('*');
        $ioController = new IoController();
        $query = $ioController->search_tool($query,$search);
        if($mode == null) {
            $data = $query->paginate(10);
            return view('project.index')
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
        return redirect('project'.$search);
    }

    public function info($id){
        $field = [];
        if($id != 'new'){
            $field = Project::find($id);
        }
        $client = Client::orderBy('name','asc')->get();
        return view('project.info')
            ->with('id', $id)
            ->with('field', $field)
            ->with('client', $client);
    }

    public function save(Request $request, $id){
        if($id == 'new'){
            $field = Project::create($request->all());
            $action = "added";
        }else{
            $field = Project::find($id);
            $field->update($request->all());
            $action = "updated";
        }
        if($request->hasFile('image')){
            if(($id != 'new') and (Storage::exists('project/'.$field->image))){
                unlink(storage_path('app/project/'.$field->image));
            }
            $filename = str_random(60).'.'.$request->file('image')->extension();
            Storage::putFileAs('project',$request->file('image'),$filename);
            $field->image = $filename;
            $field->save();
        }
        if($request->hasFile('banner')){
            if(($id != 'new') and (Storage::exists('project/'.$field->banner))){
                unlink(storage_path('app/project/'.$field->banner));
            }
            $filename = str_random(60).'.'.$request->file('banner')->extension();
            Storage::putFileAs('project',$request->file('banner'),$filename);
            $field->banner = $filename;
            $field->save();
        }
        $ioController = new IoController();
        $ioController->save_user_log(null,$request->input('_token'),$action,"users;".json_encode($field));
        $message['type'] = 'success';
        $message['content'] = "Project Successfully ".ucwords($action);
        return redirect('project')
            ->with('message',$message);
    }

    public function delete(Request $request,$id){
        $field = Project::find($id);
        try {
            $field->delete();
            $ioController = new IoController();
            $ioController->save_user_log(null,$request->input('_token'),"deleted","users;".json_encode($field));
            $message['type'] = 'success';
            $message['content'] = "Project Successfully Deleted";
        } catch (\Exception $e) {
            $message['type'] = 'danger';
            $message['content'] = "Project Cannot Deleted";
        }
        return redirect('project')
            ->with('message',$message);
    }

    public function attachment($id){
        $project = Project::find($id);
        $attachment = [];
        if($project->attachment != ""){
            $attachment = json_decode($project->attachment);
        }
        return view('project.attachment')
            ->with('id', $id)
            ->with('project', $project)
            ->with('attachment', $attachment);
    }

    public function save_attachment(Request $request, $id){
        $project = Project::find($id);
        $attachment = [];
        $length = 0;
        if($project->attachment != ""){
            $attachment = json_decode($project->attachment);
            $length = count($attachment);
        }
        $original_name = $request->file('attachment')->getClientOriginalName();
        $original_name = strtolower(str_replace(" ","_",$original_name));
        $filename = str_random(60).';'.$original_name;
        Storage::putFileAs('attachment',$request->file('attachment'),$filename);
        $attachment[$length] = $filename;
        $project->attachment = json_encode($attachment);
        $project->save();
        $ioController = new IoController();
        $ioController->save_user_log(null,$request->input('_token'),"updated","project;".json_encode($project));
        $message['type'] = 'success';
        $message['content'] = "Attachment Successfully Uploaded";
        return redirect('project/attachment/'.$id)
            ->with('message',$message);
    }

    public function delete_attachment(Request $request, $id){
        $project = Project::find($id);
        $attachment = json_decode($project->attachment);
        array_splice($attachment, $request->input('index'), 1);
        $project->attachment = json_encode($attachment);
        $project->save();
        $message['type'] = 'success';
        $message['content'] = "Attachment Successfully Deleted";
        return redirect('project/attachment/'.$id)
            ->with('message',$message);
    }
}

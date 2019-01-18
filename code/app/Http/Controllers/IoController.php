<?php

namespace App\Http\Controllers;

use App\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class IoController extends Controller
{
    public function save_user_log($user_id,$token,$action,$log){
        if($user_id == null){
            $user_active = Session::get('user_active');
            $user_id = $user_active->id;
        }
        $field = [
            'user_id' => $user_id,
            'token' => $token,
            'action' => $action,
            'date' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'log' => $log
        ];
        UserLog::create($field);
    }

    public function search_tool($query,$search){
        if($search != null){
            $search_array = explode(";",$search);
            array_pop($search_array);
            foreach($search_array as $value){
                $search_part = explode(',',$value);
                if($search_part[2] != 'all'){
                    if((strpos($search_part[0], 'tanggal') !== false) or (strpos($search_part[0], 'date') !== false)) {
                        $keyword = $search_part[2];
                        $query = $query->where($search_part[0],$search_part[1],date('Y-m-d',strtotime($keyword)));
                    }else{
                        $keyword = $search_part[2];
                        if($search_part[1] == 'like'){
                            $keyword = '%'.$search_part[2].'%';
                        }
                        $query = $query->where($search_part[0],$search_part[1],$keyword);
                    }
                }
            }
        }
        return $query;
    }
}

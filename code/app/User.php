<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['user_level_id','fullname','email'];
    protected $guarded = ['password','token'];

    public function user_level(){
        return $this->belongsTo('App\UserLevel');
    }
}

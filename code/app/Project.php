<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['client_id','name','description'];
    protected $guarded = ['image','banner','attachment'];

    public function client(){
        return $this->belongsTo('App\Client');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name','client_type_id','location_id'];
    protected $guarded = ['logo'];

    public function client_type(){
        return $this->belongsTo('App\ClientType');
    }

    public function location(){
        return $this->belongsTo('App\Location');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    protected $fillable = [
        'project_id','name','type','hostname','port','username',
        'password','url'
    ];
}

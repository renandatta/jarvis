<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['user_id','fullname','position'];
    protected $guarded = ['photo','contact'];
}

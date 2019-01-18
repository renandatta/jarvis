<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimelineProject extends Model
{
    protected $fillable = ['project_id','team_id','date','time','description'];
    protected $guarded = ['status'];
}

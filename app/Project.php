<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function masalah(){
        return $this->hasMany('App\Masalah');
    }

    public function tek_support()
    {
        return $this->belongsTo('App\TeknikalSupport');
    }
}

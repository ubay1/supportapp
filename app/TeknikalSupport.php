<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeknikalSupport extends Model
{
    protected $table = 'teknikal_supports';
    protected $fillable = ["id","nama","email","password"];
    // protected $hidden = ['password'];

    public function project()
    {
        return $this->hasMany('App\Project');
    }
}

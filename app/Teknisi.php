<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teknisi extends Model
{
    protected $table = 'teknisis';
    protected $fillable = [
        'id','nama','email', 'password'
    ];
}

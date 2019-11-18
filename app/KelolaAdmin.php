<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KelolaAdmin extends Model
{
    protected $table = 'users';
    protected $fillable = [
        'nama', 'email',
    ];
}

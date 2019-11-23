<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Masalah;
use App\Project;
use App\TeknikalSupport;
use App\Teknisi;
use Illuminate\Support\Facades\Session;

class CountController extends Controller
{

    public function getAllAdmin(){
        $data = TeknikalSupport::all();

        return $data;
    }

    public function getAllTeknisi(){
        $data = Teknisi::all();

        return $data;
    }

    public function getAllProject(){
        $data = Project::all();

        return $data;
    }

    public function getAllMasalah(){
        $data = Masalah::all();

        return $data;
    }
}

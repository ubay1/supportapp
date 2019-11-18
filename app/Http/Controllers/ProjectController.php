<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\TeknikalSupport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use DataTables;
use Redirect,Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $project = Project::with('tek_support')->get();
            return Datatables::of($project)
            ->addColumn('action', 'kelola_project/action_button')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        $t_support = TeknikalSupport::all();
        return view('kelola_project/index', ['t_support'=>$t_support]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user   = new Project();
        $user->id = $request->user_id;
        $user->tek_support_id = $request->tek_support_id;
        $user->nama_project = $request->nama_project;
        $user->created_at = Carbon::now('Asia/Jakarta');
        $user->updated_at = Carbon::now('Asia/Jakarta');
        $user->save();

        return Response::json($user);
    }

    public function updatedata(Request $request)
    {
        $userId = $request->user_id2;
        $updateuser =  Project::where('id',$userId)
                    ->update([
                        'id' => $userId,
                        "nama_project" => $request->nama2,
                        "tek_support_id"=> $request->tek_support_id,
                        "updated_at" => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s')
                    ]);

        return Response::json($updateuser);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $user  = Project::with('tek_support')->where($where)->first();

        return Response::json($user);
    }

    public function destroy($id)
    {
        $data = Project::where('id', $id)->delete();

        return response()->json($data, 200);
    }

    public function ceknamaproject(Request $request){
        $namaproject = $request->input('nama_project');
        $data = Project::where('nama_project', $namaproject)->first();

        if (!$data) {
            return response()->json([
                'message'=>'nama project tersedia',
                'statuscode'=>1
            ]);
        } else{
            return response()->json([
                'message'=>'nama project telah digunakan',
                'statuscode'=>0
            ]);
        }
    }

    public function getTS(){
        $data = TeknikalSupport::all();
        return $data;
        // $selected = [];
        // foreach($data as $datas){
        //     $selected[$datas->id] = $datas->nama;
        // }
        // return $selected;
        // return view('kelola_project/index',compact('data'));
    }
}

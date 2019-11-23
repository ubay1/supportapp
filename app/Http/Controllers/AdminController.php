<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TeknikalSupport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use DataTables;
use Redirect,Response;

class AdminController extends Controller
{

    public function index()
    {
        if(Session::get('jabatan') != "superadmin"){
            return redirect('/')->with('akses', ' anda tidak dapat akses ke page ini');
        }
        if(request()->ajax()) {
            return Datatables::of(TeknikalSupport::all())
            ->addColumn('action', 'kelola_admin/action_button')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('kelola_admin/index');
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        $user   =  new TeknikalSupport();
        $user->id = $request->user_id;
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->status = "none";
        $user->created_at = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $user->updated_at = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $user->save();

        return Response::json($user);
    }

    public function updatedata(Request $request)
    {
        $userId = $request->user_id2;
        $updateuser =  TeknikalSupport::where('id',$userId)
                    ->update([
                        'id' => $userId,
                        "nama" => $request->nama2,
                        "email" => $request->email2,
                        "password" => $request->password2,
                        "updated_at" => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s')
                    ]);
                    print_r($updateuser);
                    die();

        return Response::json($updateuser);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $user  = TeknikalSupport::where($where)->first();

        return Response::json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = TeknikalSupport::where('id', $id)->delete();

        return response()->json($data, 200);
    }

    public function cekemail(Request $request){
        $email = $request->input('email');
        $data = TeknikalSupport::where('email', $email)->first();

        if (!$data) {
            return response()->json([
                'message'=>'email tersedia',
                'statuscode'=>1
            ]);
        } else{
            return response()->json([
                'message'=>'email telah digunakan',
                'statuscode'=>0
            ]);
        }
    }
}

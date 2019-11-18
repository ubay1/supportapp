<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Teknisi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use DataTables;
use Redirect,Response;

class TeknisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(Session::get('jabatan') != "admin"){
        //     return redirect('/')->with('akses', ' anda tidak dapat akses ke page ini');
        // }
        if(request()->ajax()) {
            return Datatables::of(Teknisi::all())
            ->addColumn('action', 'kelola_teknisi/action_button')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('kelola_teknisi/index');
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
        $user   =  new Teknisi();
        $user->id = $request->user_id;
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->created_at = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $user->updated_at = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $user->save();

        return Response::json($user);
    }

    public function updatedata(Request $request)
    {
        $userId = $request->user_id2;
        $updateuser =  Teknisi::where('id',$userId)
                    ->update([
                        'id' => $userId,
                        "nama" => $request->nama2,
                        "email" => $request->email2,
                        "password" => $request->password2,
                        "updated_at" => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s')
                    ]);
                    // print_r($updateuser);
                    // die();

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
        $user  = Teknisi::where($where)->first();

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
        $data = Teknisi::where('id', $id)->delete();

        return response()->json($data, 200);
    }

    public function cekemail(Request $request){
        $email = $request->input('email');
        $data = Teknisi::where('email', $email)->first();

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

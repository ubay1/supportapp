<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Masalah;
use App\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use DataTables;
use Redirect,Response;

class MasalahController extends Controller
{
    public function index()
    {
        // $masalah = Masalah::with('projects')->get();
        // return $masalah;

        if(request()->ajax()) {
            $masalah = Masalah::with(['project'=>function($q){
                $q->select('id','nama_project');
            }])->get();
            return Datatables::of($masalah)
            ->addColumn('picture', function($masalah){
                $url=asset("uploads/".$masalah->picture);
                return '<img src="'.$url.'" border="0" width="100" class="img-rounded" align="center" />';
            })
            ->addColumn('action', 'kelola_masalah_project/action_button')
            ->rawColumns(['picture','action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('kelola_masalah_project/index');
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
        $pesan = [
            "required"=>":attribute wajib diisi",
            "min"=>":attribute harus diisi minimal :min karakter"
          ];

          $validator = Validator::make($request->all(), [
            'project_id'=>'required',
            'masalah'=>'required',
            'solusi'=>'required',
            'picture'=>'required'
          ], $pesan);

          // cek error tiap" request
          if ($validator->fails()) {
            if ($validator->errors()->first('project_id')) {
                return response()->json([
                  'data'=>[
                    'success'       => false,
                    'status_code'    => 4003,
                    'message'       => $validator->errors()->first('project_id'),
                    'error'         => $validator->errors()->first('project_id'),
                    'value'          => null,
                  ]
                ]);
              } elseif ($validator->errors()->first('masalah')) {
                return response()->json([
                  'data'=>[
                    'success'       => false,
                    'status_code'    => 4004,
                    'message'       => $validator->errors()->first('masalah'),
                    'error'         => $validator->errors()->first('masalah'),
                    'value'          => null,
                  ]
                ]);
              }
            elseif ($validator->errors()->first('solusi')) {
              return response()->json([
                'data'=>[
                  'success'       => false,
                  'status_code'    => 4001,
                  'message'       => $validator->errors()->first('solusi'),
                  'error'         => $validator->errors()->first('solusi'),
                  'value'          => null,
                ]
              ]);
            } elseif ($validator->errors()->first('gambar')) {
              return response()->json([
                'data'=>[
                  'success'       => false,
                  'status_code'    => 4002,
                  'message'       => $validator->errors()->first('gambar'),
                  'error'         => $validator->errors()->first('gambar'),
                  'value'          => null,
                ]
              ]);
            }
          }

          $masalah_baru = new Masalah();
          $masalah_baru->project_id = $request->input('project_id');
          $masalah_baru->masalah = $request->input('masalah');
          $masalah_baru->solusi = $request->input('solusi');
          $masalah_baru->picture = $request->input('picture');
                $file = $request->file('picture');
                $ext = $file->getClientOriginalExtension();
                $newName = rand(100000,1001238912).md5($file->getClientOriginalName()).'.'.$ext;
                $file->move('uploads',$newName);
        //   $masalah_baru->picture = Config('app.url').'uploads/'.$newName;
            $masalah_baru->picture = $newName;
          $masalah_baru->created_at = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
          $masalah_baru->updated_at = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
          $masalah_baru->save();

          return response()->json([
            'data'=>[
              'success' => true,
              'statuscode' => 2001,
              'message' => 'Masalah sukses disimpan',
              'error' => '',
              'data' => $masalah_baru,
            ]
          ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user   = new Masalah();
        $user->id = $request->user_id;
        $user->nama_project = $request->nama_project;
        $user->created_at = Carbon::now('Asia/Jakarta');
        $user->updated_at = Carbon::now('Asia/Jakarta');
        $user->save();

        return Response::json($user);
    }

    public function updatedata(Request $request)
    {
        $picturebaru = $request->isi_picturelama;
        $images = $request->file('isi_picturebaru');

        if ($images != '') {
            $rules = array(
                'isi_masalah' => 'required',
                'isi_solusi'  => 'required',
                'isi_picturebaru' => 'required'
            );

            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return response()->json([
                    'error'=>$validator->errors()->all()
                ]);
            }

            $data2 = DB::table('masalahs')
            ->where('id','=', $request->id_masalah)
            ->first();

            Storage::delete('uploads/'.$data2->picture);

            $ext = $images->getClientOriginalExtension();
            $image_name = rand(100000,1001238912).md5($images->getClientOriginalName()).'.'.$ext;
            $images->move('uploads',$image_name);

            $form_data = array(
                'masalah' => $request->isi_masalah,
                'solusi'  => $request->isi_solusi,
                'picture' => $image_name,
                'updated_at' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s')
            );
        }
        else{
            $rules = array(
                'isi_masalah' => 'required',
                'isi_solusi'  => 'required'
            );

            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return response()->json([
                    'error'=>$validator->errors()->all()
                ]);
            }

            $form_data = array(
                'masalah' => $request->isi_masalah,
                'solusi'  => $request->isi_solusi,
                'updated_at' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s')
            );
        }

        Masalah::where('id',$request->id_masalah)->update($form_data);

            return response()->json([
                'data'=>[
                'success' => true,
                'statuscode' =>2001,
                'message' => 'Data sukses diupdate',
                'data' => $form_data,
                ]
            ]);
    }

    public function hapusMasalah($id){
        $data2 = DB::table('masalah')
        ->where('id','=', $id)
        ->first();

        Storage::delete('uploads/'.$data2->picture);

        // $jabatan = Session::get('jabatan');
        $data2 = DB::table('masalah')
        ->where('id','=', $id)
        ->delete();

        $res['data']= array(
            'message'=>'success delete'
        );

        return response($res);
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
        $user  = Masalah::with('project')->where($where)->first();

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
}

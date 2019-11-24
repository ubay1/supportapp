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
        $t_support = Project::with(['tek_support'=>function($q){
            $q->where('id',Session::get('id'));
        }])->where('tek_Support_id', Session::get('id'))->get();
        // return $t_support[0];

        return view('kelola_masalah_project/index')->with('tmpsupport', $t_support);
    }

    public function getMasalah($id){
        $t_support = Masalah::with(['project'=>function($q){
            $q->with('tek_support');
        }])->where('tek_Support_id', $id)->orderBy('id','DESC')->get();

        return $t_support;
    }

    public function create()
    {
        //
    }

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
            'picture'=>'required',
            'tek_support_id' => 'required'
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
            } elseif ($validator->errors()->first('tek_support_id')) {
                return response()->json([
                  'data'=>[
                    'success'       => false,
                    'status_code'    => 4002,
                    'message'       => $validator->errors()->first('tek_support_id'),
                    'error'         => $validator->errors()->first('tek_support_id'),
                    'value'          => null,
                  ]
                ]);
              }
          }

        //   return $request->input('project_id') ." ".$request->input('tek_support_id');

          $masalah_baru = new Masalah();
          $masalah_baru->project_id = $request->input('project_id');
          $masalah_baru->masalah = $request->input('masalah');
          $masalah_baru->solusi = $request->input('solusi');
          $masalah_baru->picture = $request->input('picture');
                $file = $request->file('picture');
                $ext = $file->getClientOriginalExtension();
                $newName = rand(100000,1001238912).md5($file->getClientOriginalName()).'.'.$ext;
                $file->move('uploads/masalah/',$newName);
        //   $masalah_baru->picture = Config('app.url').'uploads/'.$newName;
          $masalah_baru->picture = $newName;
          $masalah_baru->created_at = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
          $masalah_baru->updated_at = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
          $masalah_baru->tek_support_id = $request->input('tek_support_id');
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

    public function show($id)
    {
        $where = array('id' => $id);
        $user  = Masalah::with('project')->where($where)->first();

        return Response::json($user);
        // $t_support = Project::with(['tek_support', 'masalah'])->where('tek_support_id', $id)->get();

        // return Response::json($t_support);
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

            File::delete('uploads/masalah/'.$data2->picture);

            $ext = $images->getClientOriginalExtension();
            $image_name = rand(100000,1001238912).md5($images->getClientOriginalName()).'.'.$ext;
            $images->move('uploads/masalah/',$image_name);

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
        $data2 = Masalah::find($id)->first();

        File::delete('uploads/masalah/'.$data2->picture);

        $data2 = Masalah::find($id)->delete();

        return response()->json([
            'message'=>'success delete',
            'success'=>true,
            'statuscode'=>200
        ]);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $user  = Masalah::with('project')->where($where)->first();

        return Response::json($user);
    }

    public function update(Request $request, $id)
    {
        //
    }

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

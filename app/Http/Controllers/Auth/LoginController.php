<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\SuperAdmin;
use App\Admin;

use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        $pesan = [
            "required"=>":attribute wajib diisi",
            "min"=>":attribute harus diisi minimal :min karakter"
        ];

        $validator = Validator::make($request->all(), [
            'email'=>'required|email',
            'password'=>'required',
            'role'=>'required'
        ], $pesan);

        if ($validator->fails()) {
            if ($validator->errors()->first('email')) {
                return response()->json([
                    'success'       => false,
                    'statuscode'    => 4001,
                    'message'       => $validator->errors()->first('email'),
                    'error'         => $validator->errors()->first('email'),
                    'data'          => null,
                ]);
            } elseif ($validator->errors()->first('password')) {
                return response()->json([
                    'success'       => false,
                    'statuscode'    => 4002,
                    'message'       => $validator->errors()->first('password'),
                    'error'         => $validator->errors()->first('password'),
                    'data'          => null,
                ]);
            } elseif ($validator->errors()->first('role')) {
                return response()->json([
                    'success'       => false,
                    'statuscode'    => 4002,
                    'message'       => $validator->errors()->first('role'),
                    'error'         => $validator->errors()->first('role'),
                    'data'          => null,
                ]);
            }
        }

        if ($request->input('role') == 1) {
            $email    = $request->input('email');
            $password = $request->input('password');

            $superadmin = SuperAdmin::where('email',$email)->where('password',$password)->get();
            return $superadmin;

            if (!$superadmin) {
                return response()->json([
                    'data'=>[
                        'success' => false,
                        'statuscode' => 4001,
                        'message' => 'data yang anda masukan tidak terdaftar'
                    ]
                ]);
            } else{
                Session::put('nama',$request->nama);
                Session::put('email',$request->email);
                Session::put('login',TRUE);
                return response()->json([
                    'data'=>[
                        'success' => true,
                        'statuscode' => 2001,
                        'message' => 'Selamat anda berhasil masuk',
                    ]
                ]);
            }
        } else{
            $email    = $request->input('email');
            $password = $request->input('password');

            $admin = SuperAdmin::where('email',$email)->where('password',$password)->get();
            return $admin;

            if (!$admin) {
                return response()->json([
                    'data'=>[
                        'success' => false,
                        'statuscode' => 4001,
                        'message' => 'data yang anda masukan tidak terdaftar'
                    ]
                ]);
            } else{
                return response()->json([
                    'data'=>[
                        'success' => true,
                        'statuscode' => 200,
                        'message' => 'data yang anda masukan tersedia',
                    ]
                ]);
            }
        }

        $req_pas = $request->input('password');
        $user_Pass = User::where('password', $req_pas)->first();

        if (count($user_Email) > 0) {

            // print_r( $user_Pass);
            // die();

            if ($user_Pass) {
                return $res['data']=array(
                    'message'=>'sukses login',
                    'value'=>$user_Email
                );
            }
            else{
                return $res['data']=array(
                    'message'=>'password salah'
                );
            }
        }
        else{
            return $res['data']=array(
                'message'=>'data tidak tersedia'
            );
        }
    }

    public function getAllData(){
        $data = User::all();

        if (count($data)>0) {
            $res['data']= array(
                'message'=>'success',
                'value'=>$data
            );

            return response($res);
        }
        else{
            $res['data']= array(
                'message'=>'data tidak ditemukan',
            );

            return response($res);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SuperAdmin;
use App\TeknikalSupport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    public function index(){
        if(!Session::get('email')){
            return redirect('admin/login')->with('alert','Kamu harus login dulu');
        }
        else{
            return view('home');
        }
    }

    public function login(){
        if(Session::get('email')){
            return redirect('/admin')->with('alert-sukses','Kamu sudah ada akses');
        }
        else{
            return view('login');
        }
    }

    public function loginPost(Request $request){

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
                    'statuscode'    => 4003,
                    'message'       => $validator->errors()->first('role'),
                    'error'         => $validator->errors()->first('role'),
                    'data'          => null,
                ]);
            }
        }

        if ($request->input('role') == 1) {
            $email    = $request->input('email');
            $password = $request->input('password');

            $superadmin = SuperAdmin::where('email','=',$email)->first();
            // return $superadmin;

            if (!$superadmin) {
                return redirect('admin/login')->with('alert','Role yang and pilih tidak sesuai !');
                // return response()->json([
                //     'data'=>[
                //         'messsage'=>'Role yang and pilih tidak sesuai !',
                //         'success'=>false,
                //         'statuscode'=>4003
                //     ]
                // ]);
            }
            else{
                if ($email == $superadmin->email) {
                    // return $superadmin->email;

                    if ($password != $superadmin->password) {
                        return redirect('admin/login')->with('alert','password yang and masukan tidak sesuai !');
                        // return response()->json([
                        //     'data'=>[
                        //         'success' => false,
                        //         'statuscode' => 4002,
                        //         'message' => 'Password yang anda masukan salah'
                        //     ]
                        // ]);
                    }else{
                        Session::put('id',$superadmin->id);
                        Session::put('nama',$superadmin->nama);
                        Session::put('email',$superadmin->email);
                        Session::put('jabatan','superadmin');
                        Session::put('login',TRUE);
                        return redirect('admin');
                        // return response()->json([
                        //     'data'=>[
                        //         'success' => true,
                        //         'statuscode' => 2001,
                        //         'message' => 'Selamat anda berhasil masuk',
                        //         $getid
                        //     ]
                        // ]);
                    }
                }else{

                    return redirect('admin/login')->with('alert','email yang anda masukan tidak terdaftar !');
                    // return response()->json([
                    //     'data'=>[
                    //         'messsage'=>'email yang anda masukan tidak terdaftar',
                    //         'success'=>false,
                    //         'statuscode'=>4001
                    //     ]
                    // ]);
                }
            }
        }
        else{
            $email = $request->input('email');
            $password = $request->input('password');

            $admin = TeknikalSupport::where('email','=',$email)->first();

            if (!$admin) {
                return redirect('admin/login')->with('alert','Role yang and pilih tidak sesuai !');
                // return response()->json([
                //     'data'=>[
                //         'messsage'=>'Role yang and pilih tidak sesuai !',
                //         'success'=>false,
                //         'statuscode'=>4003
                //     ]
                // ]);
            }
            else{
                if ($email == $admin->email) {
                    if ($password != $admin->password) {
                    return redirect('admin/login')->with('alert','password yang and masukan tidak sesuai !');
                        // return response()->json([
                        //     'data'=>[
                        //         'success' => false,
                        //         'statuscode' => 4002,
                        //         'message' => 'Password yang anda masukan salah'
                        //     ]
                        // ]);
                    }else{
                        Session::put('id',$admin->id);
                        Session::put('nama',$admin->nama);
                        Session::put('email',$admin->email);
                        Session::put('jabatan','admin');
                        Session::put('login',TRUE);
                        return redirect('admin');
                        // return response()->json([
                        //     'data'=>[
                        //         'success' => true,
                        //         'statuscode' => 2001,
                        //         'message' => 'Selamat anda berhasil masuk',
                        //     ]
                        // ]);
                    }
                }else{
                    return redirect('admin/login')->with('alert','email yang and masukan tidak terdaftar !');
                    // return response()->json([
                    //     'data'=>[
                    //         'messsage'=>'email yang anda masukan tidak terdaftar',
                    //         'success'=>false,
                    //         'statuscode'=>4001
                    //     ]
                    // ]);
                }
            }
        }
    }

    public function logout(){
        Session::flush();
        return redirect('admin/login')->with('alert-success','Kamu sudah logout');
    }
}

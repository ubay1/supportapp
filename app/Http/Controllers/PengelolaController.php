<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SuperAdmin;
use App\TeknikalSupport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PengelolaController extends Controller
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
            $email = $request->input('email');
            $password = $request->input('password');

            $superadmin = SuperAdmin::all()->where('email','=',$email);
            return $superadmin;

            if (!$superadmin[1]) {
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
                if ($email == $superadmin[1]->email) {
                    // return $superadmin[1]->email;

                    if ($password != $superadmin[1]->password) {
                        return redirect('admin/login')->with('alert','password yang and masukan tidak sesuai !');
                        // return response()->json([
                        //     'data'=>[
                        //         'success' => false,
                        //         'statuscode' => 4002,
                        //         'message' => 'Password yang anda masukan salah'
                        //     ]
                        // ]);
                    }else{
                        Session::put('id',$superadmin[1]->id);
                        Session::put('nama',$superadmin[1]->nama);
                        Session::put('email',$superadmin[1]->email);
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

            $admin = Admin::all()->where('email','=',$email);

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
                    // return redirect('login')->with('alert','password yang and masukan tidak sesuai !');
                        return response()->json([
                            'data'=>[
                                'success' => false,
                                'statuscode' => 4002,
                                'message' => 'Password yang anda masukan salah'
                            ]
                        ]);
                    }else{
                        Session::put('id',$admin->id);
                        Session::put('nama',$admin->nama);
                        Session::put('email',$admin->email);
                        Session::put('jabatan','admin');
                        Session::put('login',TRUE);
                        return response()->json([
                            'data'=>[
                                'success' => true,
                                'statuscode' => 2001,
                                'message' => 'Selamat anda berhasil masuk',
                            ]
                        ]);
                    }
                }else{
                    // return redirect('login')->with('alert','email yang and masukan tidak terdaftar !');
                    return response()->json([
                        'data'=>[
                            'messsage'=>'email yang anda masukan tidak terdaftar',
                            'success'=>false,
                            'statuscode'=>4001
                        ]
                    ]);
                }
            }
        }
    }

    public function logout(){
        Session::flush();
        return redirect('login')->with('alert-success','Kamu sudah logout');
    }
}

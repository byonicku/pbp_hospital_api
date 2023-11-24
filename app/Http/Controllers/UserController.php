<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::all();

            return response()->json([
                "status" => true,
                "message" => 'Berhasil ambil data user',
                "data" => $users
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $newUser = $request->all();
    
            $validate = Validator::make($newUser, [
                "email" => 'unique:users'
            ]);
    
            if ($validate->fails()) {
                return response()->json([
                    'status'=> false,
                    'message'=> $validate->errors(),
                ], 400);
            }

            $newUser["profile_photo"] = "";
    
            $user = User::create($newUser);

            return response()->json([
                'status'=> true,
                'message'=> 'Berhasil Register User',
                'data'=> $user
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'=> false,
                'message'=> $e->getMessage(),
                'data'=> []
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $user = User::where('id_user', $id)->first();

            if(!is_null($user)) {
                return response()->json([
                    'status'=> true,
                    'message'=> 'Berhasil Ambil Data User',
                    'data'=> $user
                ], 200);
            } else {
                return response()->json([
                    'status'=> false,
                    'message'=> 'User Tidak Ditemukan',
                    'data'=> []
                ], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'=> false,
                'message'=> $e->getMessage(),
                'data'=> []
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function login(Request $request)
    {
        try {
            $user = User::where('username', $request->username)->where('password', $request->password)->first();

            if(!is_null($user)) {
                return response()->json([
                    'status'=> true,
                    'message'=> 'Berhasil Ambil Data User',
                    'data'=> $user
                ], 200);
            } else {

                $user = User::where('username', $request->username)->first();

                if(!is_null($user)) {
                    return response()->json([
                        'status'=> true,
                        'message'=> 'Username atau Password masukkan Salah',
                    ], 400);
                }

                return response()->json([
                    'status'=> false,
                    'message'=> 'User Tidak Ditemukan',
                    'data'=> []
                ], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'=> false,
                'message'=> $e->getMessage(),
                'data'=> []
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::where('id_user', $id)->first();

            if(!is_null($user)) {
                $userUpdate = $request->all();

                $validate = Validator::make($userUpdate, [
                    'email'=> Rule::unique('users')->where("id_user", "<>", $id),
                ]);

                if ($validate->fails()) {
                    return response()->json([
                        'status'=> false,
                        'message'=> $validate->errors(),
                    ], 400);
                }

                if(is_null($userUpdate["profile_photo"])){
                    $userUpdate["profile_photo"] = "";
                }

                $result = DB::table('users')->where('id_user', $id)->update([
                    "username" => $userUpdate["username"],
                    "email"=> $userUpdate["email"],
                    "password" => $userUpdate["password"],
                    "no_telp" => $userUpdate["no_telp"],
                    "tanggal_lahir" => $userUpdate["tanggal_lahir"],
                    "jenis_kelamin" => $userUpdate["jenis_kelamin"],
                    "profile_photo" => $userUpdate["profile_photo"],
                ]);

                if ($result > 0) {
                    return response()->json([
                        'status'=> true,
                        'message'=> 'Berhasil Update Data User'
                    ], 200);
                }

                return response()->json([
                    'status'=> false,
                    'message'=> 'Gagal Update Data User'
                ], 400);

                return response()->json([
                    'status'=> true,
                    'message'=> 'Berhasil Update Data User'
                ], 200);
            } else {
                return response()->json([
                    'status'=> false,
                    'message'=> 'User Tidak Ditemukan'
                ], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'=> false,
                'message'=> $e->getMessage(),
                'data'=> []
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            if(!is_null($user)) {
                $user->delete();

                return response()->json([
                    'status'=> true,
                    'message'=> 'Berhasil Hapus Data User'
                ], 200);
            } else {
                return response()->json([
                    'status'=> false,
                    'message'=> 'Data User Tidak Ditemukan'
                ], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'=> false,
                'message'=> $e->getMessage(),
                'data'=> []
            ], 400);
        }
    }
}

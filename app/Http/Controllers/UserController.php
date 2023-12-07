<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

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
                    'email'=> ['required', 'email',
                        Rule::unique('users')->ignore($id, 'id_user'),
                    ]
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

                if($request->has('profile_photo')){
                    $imageName = time() . '-' . $user->username . '.jpg';
                    $imageFile = base64_decode($request->profile_photo);

                    if (!file_exists(Storage::disk('public')->path('user'))) {
                        mkdir(Storage::disk('public')->path('user'), 0777, true);
                    }

                    if (file_exists(Storage::disk('public')->path('user') . '/' . $user->profile_photo)) {
                        unlink(Storage::disk('public')->path('user') . '/' . $user->profile_photo);
                    }

                    Storage::disk('public')->put('user' . $imageName, $imageFile);

                    $userUpdate["profile_photo"] = $imageName;
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
                    'message'=> 'Gagal Update Data User',
                    'result' => $result
                ], 400);
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

    public function updatePfp(Request $request)
    {
        try {
            $user = User::where('id_user', $request->id)->first();

            if(!is_null($user)) {
                $userUpdate = $request->all();

                if($request->has('profile_photo')){
                    $imageName = time() . '-' . $user->username . '.jpg';
                    $imageFile = base64_decode($request->profile_photo);

                    if (!file_exists(Storage::disk('public')->path('user'))) {
                        mkdir(Storage::disk('public')->path('user'), 0777, true);
                    }

                    if (file_exists(Storage::disk('public')->path('user') . '/' . $user->profile_photo)) {
                        unlink(Storage::disk('public')->path('user') . '/' . $user->profile_photo);
                    }

                    Storage::disk('public')->put('user' . $imageName, $imageFile);

                    $userUpdate["profile_photo"] = $imageName;
                }

                $result = DB::table('users')->where('id_user', $request->id)->update([
                    "profile_photo" => $userUpdate["profile_photo"],
                ]);

                if ($result > 0) {
                    return response()->json([
                        'status'=> true,
                        'message'=> 'Berhasil Update Photo Profil User'
                    ], 200);
                }

                return response()->json([
                    'status'=> false,
                    'message'=> 'Gagal Update Photo Profil User'
                ], 400);
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

    public function updatePass(Request $request){
        $userToUpdate = User::where("username", $request->username)->first();

        if(!is_null($userToUpdate)){
            if($userToUpdate->password != $request->passwordLama){
                return response()->json([
                    "status"=> false,
                    "message"=> "Password Lama Tidak Sesuai"
                ], 400);
            }

            $result = DB::table("users")->where("id_user", $userToUpdate->id_user)->update(["password" => $request->passwordBaru]);

            if ($result > 0){
                return response()->json([
                    "status"=> true,
                    "message"=> "Berhasil Update Password",
                ], 200);
            }

            return response()->json([
                "status"=> false,
                "message"=> "Gagal Update Password"
            ], 400);
        }

        return response()->json([
            "status"=> false,
            "message"=> "Username Tidak Ditemukan"
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);

            unlink(public_path($user->profile_photo));

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

<?php

namespace App\Http\Controllers;

use App\Models\DaftarPeriksa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class DaftarPeriksaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $daftarPeriksa = DaftarPeriksa::all();

            if(!is_null($daftarPeriksa)){
                return response()->json([
                    "status" => true,
                    "message" => "Berhasil Mengambil Data Daftar Periksa",
                    "data"=> $daftarPeriksa
                ], 200);
            }

            return response()->json([
                "status"=> true,
                "message"=> "Daftar Periksa Kosong"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message"=> $e->getMessage()
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $daftarperiksaNew = $request->all();

            $daftarPeriksa = DaftarPeriksa::create($daftarperiksaNew);

            return response()->json([
                "status"=> true,
                "message"=> "Berhasil Menambah Daftar Periksa",
                "data"=> $daftarPeriksa
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status"=> false,
                "message"=> $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        try {
            $daftarPeriksa = DaftarPeriksa::find($id);

            if(!is_null($daftarPeriksa)){
                return response()->json([
                    "status" => true,
                    "message" => "Berhasil Mengambil Data Daftar Periksa",
                    "data"=> $daftarPeriksa
                ], 200);
            }

            return response()->json([
                "status"=> true,
                "message"=> "Daftar Periksa Kosong"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message"=> $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $findDaftarPeriksa = DaftarPeriksa::find($request->id_daftar_periksa);

            if(is_null($findDaftarPeriksa)) {
                return response()->json([
                    "status"=> false,
                    "message"=> "Daftar Periksa Tidak Ditemukan"
                ], 400);
            }

            $daftarPeriksaUpdate = $request->all();
            $findDaftarPeriksa->update($daftarPeriksaUpdate);

            return response()->json([
                "status"=> true,
                "message"=> "Berhasil Update Daftar Periksa",
                "data"=> $daftarPeriksaUpdate
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status"=> false,
                "message"=> $e->getMessage()
            ], 400);
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $findDaftarPeriksa = DaftarPeriksa::find($request->id);

            if(is_null($findDaftarPeriksa)) {
                return response()->json([
                    "status"=> false,
                    "message"=> "Daftar Periksa Tidak Ditemukan"
                ], 400);
            }

            $daftarPeriksaUpdate = $findDaftarPeriksa;
            $daftarPeriksaUpdate = [
                "status_checkin" => 1
            ];
            $findDaftarPeriksa->update($daftarPeriksaUpdate);

            return response()->json([
                "status"=> true,
                "message"=> "Berhasil Update Daftar Periksa",
                "data"=> $daftarPeriksaUpdate
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status"=> false,
                "message"=> $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $findDaftarPeriksa = DaftarPeriksa::where("id_daftar_periksa", $id)->first();

            if(is_null($findDaftarPeriksa)) {
                return response()->json([
                    "status"=> false,
                    "message"=> "Daftar Periksa Tidak Ditemukan"
                ], 400);
            }

            $findDaftarPeriksa->delete();

            return response()->json([
                "status"=> true,
                "message"=> "Berhasil Menghapus Daftar Periksa",
                "data" => $findDaftarPeriksa
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status"=> false,
                "message"=> $e->getMessage()
            ], 400);
        }
    }
}

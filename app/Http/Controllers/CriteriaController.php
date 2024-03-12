<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kriteria = Criteria::get();
        return view('kriteria.index', compact('kriteria'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            Criteria::create([
                'name' => $request->name,
                'code' => $request->code,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Criteria Berhasil Dibuat',
                'status' => true
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Criteria Gagal Dibuat' . $e,
                'status' => false
            ], 400);
        }
    }


    public function update(Request $request)
    {
        $request->validate([
            'updateCode' => 'string',
            'updateName' => 'string',
        ]);
        DB::beginTransaction();
        try {
            $kriteria = Criteria::findOrFail($request->id);
            $kriteria->update([
                'code' => $request->updateCode,
                'name' => $request->updateName,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Kriteria Berhasil Diupdate',
                'status' => true
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Kriteria Gagal Diupdate',
                'status' => false
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $kriteria = Criteria::findOrFail($id);
            $kriteria->delete();
            DB::commit();
            return response()->json([
                'message' => 'Kriteria Berhasil Dihapus',
                'status' => true
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Kriteria Gagal Dihapus' . $e,
                'status' => false
            ], 200);
        }
    }
}

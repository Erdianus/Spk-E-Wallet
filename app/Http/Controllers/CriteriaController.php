<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CriteriaController extends Controller
{
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
        $criteria = Criteria::find($request->id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'code' => 'required|string|unique:criterias,code',
            'type_of_criteria' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => false], 400);
        }
        DB::beginTransaction();
        try {
            Criteria::create([
                'name' => $request->name,
                'code' => $request->code,
                'type_of_criteria' => $request->type_of_criteria,
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
        $criteria = Criteria::findOrFail($request->id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'code' => 'required|string|unique:criterias,code,' . $request->id,
            'type_of_criteria' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => false], 200);
        }
        DB::beginTransaction();
        try {
            $kriteria = Criteria::findOrFail($request->id);
            $kriteria->update([
                'code' => $request->code,
                'name' => $request->name,
                'type_of_criteria' => $request->type_of_criteria,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Kriteria Berhasil Diupdate',
                'status' => true
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Kriteria Gagal Diupdate' . $e,
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

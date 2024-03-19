<?php

namespace App\Http\Controllers;

use App\Models\SubCriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubCriteriaController extends Controller
{
    public function index($id)
    {
        $subKriteria = SubCriteria::where('criteria_id', $id)
            ->orderBy('value', 'ASC')
            ->get();
        $criteria = $id;
        return view('sub-kriteria.index', compact('subKriteria', 'criteria'));
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
            'value' => 'required|integer',
            'criteria_id' => 'required|integer',
        ]);
        DB::beginTransaction();
        try {
            SubCriteria::create([
                'name' => $request->name,
                'value' => $request->value,
                'criteria_id' => $request->criteria_id,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Sub Criteria Berhasil Dibuat',
                'status' => true
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Sub Criteria Gagal Dibuat' . $e,
                'status' => false
            ], 400);
        }
    }


    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'updateName' => 'string',
            'updateValue' => 'integer',
        ]);
        DB::beginTransaction();
        try {
            $subKriteria = SubCriteria::findOrFail($request->id);
            $subKriteria->update([
                'name' => $request->updateName,
                'value' => $request->updateValue,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Sub Kriteria Berhasil Diupdate',
                'status' => true
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Sub Kriteria Gagal Diupdate',
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
            $subKriteria = SubCriteria::findOrFail($id);
            $subKriteria->delete();
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

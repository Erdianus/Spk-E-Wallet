<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AlternativeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alternatif = Alternative::get();
        $criterias = Criteria::get();
        return view('alternatif.index', compact('alternatif', 'criterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            Alternative::create([
                'name' => $request->name,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Alternatif Berhasil Dibuat',
                'status' => true
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Alternatif Gagal Dibuat' . $e,
                'status' => false
            ], 400);
        }
    }


    public function update(Request $request)
    {
        $request->validate([
            'updateName' => 'string',
        ]);
        DB::beginTransaction();
        try {
            $alternatif = Alternative::findOrFail($request->id);
            $alternatif->update([
                'name' => $request->updateName,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Alternatif Berhasil Diupdate',
                'status' => true
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Alternatif Gagal Diupdate',
                'status' => false
            ], 400);
        }
    }

    public function inputDataAlternatif(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $criterias = Criteria::pluck('id'); // Assuming 'id' is the key you want to use
            $values = $request->except('_token');
            // Combine the arrays into a single associative array
            $dataInput = array_combine($criterias->toArray(), $values);
            foreach ($dataInput as $criteriaId => $value) {
                // Access $criteriaId (criteria ID) and $value (input value) in each iteration
                Alternative::find($id)->criteria()->attach($criteriaId, ['value' => $value]);
            }
            DB::commit();
            return response()->json([
                'message' => 'Data Alternatif Berhasil Ditambahkan',
                'status' => true
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Data Alternatif Gagal Ditambahkan',
                'status' => false
            ], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $alternatif = Alternative::findOrFail($id);
            $alternatif->delete();
            DB::commit();
            return response()->json([
                'message' => 'Alternatif Berhasil Dihapus',
                'status' => true
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Alternatif Gagal Dihapus' . $e,
                'status' => false
            ], 400);
        }
    }
}

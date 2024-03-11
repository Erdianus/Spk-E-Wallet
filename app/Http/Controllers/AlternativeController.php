<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
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
        return view('alternatif.index', compact('alternatif'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('alternatif.create');
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $alternatif = Alternative::findOrFail($id);
        return view('alternatif.show', compact('alternatif'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $alternatif = Alternative::findOrFail($id);
        return view('alternatif.', compact('alternatif'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            ], 200);
        }
    }
}

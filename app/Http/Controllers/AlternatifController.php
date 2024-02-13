<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AlternatifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('alternatif.index');
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
            'nama' => 'required|string',
            'kode' => 'required|string',
        ]);
        DB::beginTransaction();
        try {
            Alternatif::create([
                'nama' => $request->nama,
                'kode' => $request->kode,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Alternatif Berhasil Dibuat',
                'status' => 200
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Alternatif Gagal Dibuat',
                'status' => 500
            ]);
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
        $alternatif = Alternatif::findOrFail($id);
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
        $alternatif = Alternatif::findOrFail($id);
        return view('alternatif.', compact('alternatif'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'string',
            'kode' => 'string',
        ]);
        DB::beginTransaction();
        try {
            $alternatif = Alternatif::findOrFail($id);
            $alternatif->update([
                'nama' => $request->nama,
                'kode' => $request->kode,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Alternatif Berhasil Diupdate',
                'status' => 200
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Alternatif Gagal Diupdate',
                'status' => 500
            ]);
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
        $alternatif = Alternatif::findOrFail($id);
        $alternatif->delete();
        return response()->json([
            'message' => 'Alternatif Berhasil Dihapus',
            'status' => 200
        ]);
    }
}

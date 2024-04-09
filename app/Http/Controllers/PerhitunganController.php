<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Alternative;
use Illuminate\Http\Request;
use App\Models\CriteriaWeight;
use Illuminate\Support\Facades\DB;
use App\Models\PerbandinganKriteria;
use Illuminate\Support\Facades\Validator;

class PerhitunganController extends Controller
{

    public function pembobotanIndex(Request $request)
    {
        $criterias = Criteria::get();
        $criterias2 = Criteria::get();
        $perbandingan_kriteria = PerbandinganKriteria::get();

        return view('pembobotan.index', compact('criterias', 'criterias2', 'perbandingan_kriteria'));
    }

    public function inputSkala(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'skala' => 'required',
                'for' => 'required|integer',
                'value' => 'required|integer',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // dd($request->all());
        $parts = explode("/", $request->skala);
        $for = $request->for;
        $data = PerbandinganKriteria::updateOrCreate(
            [
                'criteria1_id' => $parts[0],
                'criteria2_id' => $parts[1]
            ],
            [
                'criteria1_id' => $parts[0],
                'criteria2_id' => $parts[1],
                'for_criteria' => $for,
                'weight' => $request->value,
            ]
        );
        // dd($data);
        return redirect()->route('pembobotan.index');
    }

    public function checkConsistency(Request $request)
    {
        $criterias = Criteria::get();
        $criterias2 = Criteria::get();
        return view('pembobotan.check-konsistensi', compact('criterias', 'criterias2'));
    }


    public function saveWeighting(Request $request)
    {
        DB::beginTransaction();
        try {
            foreach ($request->all() as $key => $value) {
                $data = explode("-", $value);
                $criteria_id = $data[0];
                $weight = $data[1];
                CriteriaWeight::updateOrCreate(
                    ['criteria_id' => $criteria_id],
                    [
                        'criteria_id' =>  $criteria_id,
                        'weight' =>  $weight,
                    ]
                );
            }
            DB::commit();
            return response()->json(['message' => 'Bobot Berhasil Disimpan', 'status' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Bobot Gagal Disimpan' . $e, 'status' => false]);
        }
    }

    public function index()
    {

        dd(collect($this->qiValue));
        $result = $this->qiValue;
        return view('perangkingan.index', compact('alternatives'));
    }

    public function perhitungan()
    {
        $alternatives = Alternative::get();
        $criterias = Criteria::all();
        $weights = CriteriaWeight::all();
        $matrixKeputusan = [];
        $matrixKeputusanNormalisasi = [];

        //Tabel Matrix Keputusan
        foreach ($alternatives as $row => $alternative) {
            foreach ($alternative->criteria as $column => $criteria) {
                $matrixKeputusan[$column][$row] = $criteria->criteria_value->value;
            }
        }

        //Tabel Matrix Normalisasi
        foreach ($alternatives as $row => $alternative) {
            foreach ($alternative->criteria as $column => $criteria) {
                $maxValue = max($matrixKeputusan[$column]);
                $minValue = max($matrixKeputusan[$column]);
                if ($criteria->type_of_criteria == 'Benefit') {
                    $result = $criteria->criteria_value->value / $maxValue;
                } elseif ($criteria->type_of_criteria == 'Cost') {
                    $result = $minValue / $criteria->criteria_value->value;
                }
                $matrixKeputusanNormalisasi[$column][$row] = $result;
            }
        }

        //Perhitungan Nilai Qi
        $qiValue = [];
        $finalResult = [];
        foreach ($alternatives as $row => $alternative) {
            $perkalian = [];
            $perpangkatan = [];
            foreach ($criterias as $column => $criteria) {
                $perkalian[$column] =
                    $matrixKeputusanNormalisasi[$column][$row] * $criteria->weight->weight;
                $perpangkatan[$column] =
                    $matrixKeputusanNormalisasi[$column][$row] ^ $criteria->weight->weight;
            }
            $totalRowPerkalian = array_sum($perkalian);
            $totalRowPerpangkatan = array_sum($perpangkatan);
            $qiValue[$row] = 0.5 * $totalRowPerkalian + 0.5 * $totalRowPerpangkatan;
            $finalResult[$row]['qi'] = $qiValue[$row];
            $finalResult[$row]['name'] = $alternative->name;
        }
        $hasilPerangkingan = collect($finalResult)->sortByDesc('qi');

        return view('perangkingan.perhitungan', compact('criterias', 'alternatives', 'weights', 'matrixKeputusan', 'matrixKeputusanNormalisasi', 'qiValue', 'hasilPerangkingan'));
    }
}

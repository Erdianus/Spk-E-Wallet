<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Respondent;
use App\Models\Alternative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PerbandinganKriteria;
use Illuminate\Support\Facades\Validator;

class RespondenController extends Controller
{
    public function index()
    {
        $respondens = Respondent::with('perbandinganKriteria')->get();
        return view('responden.index', compact('respondens'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $responden = Respondent::findOrFail($id);
            $responden->delete();
            DB::commit();
            return response()->json([
                'message' => 'Responden Berhasil Dihapus',
                'status' => true
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Responden Gagal Dihapus' . $e,
                'status' => false
            ], 200);
        }
    }

    public function result(Respondent $responden)
    {
        // dd($responden);
        $alternatives = Alternative::get();
        $criterias = Criteria::get();
        $perbandinganKriteria = PerbandinganKriteria::where('responden_id', $responden->id)->get();
        $tablePerbandinganKriteria = [];
        $totalPerKolomTablePerbandingan = [];
        //////////////////////Perbandingan Kriteria///////////////////////
        foreach ($criterias as $baris => $criteria) {
            foreach ($criterias as $kolom => $criteria2) {
                $tablePerbandinganKriteria[$baris][$kolom] = round(number_format($perbandinganKriteria->where('criteria_baris_id', $baris + 1)->where('criteria_kolom_id', $kolom + 1)->first()->nilai, 3), 3);
            }
        }
        foreach ($criterias as $kolom => $criteria) {
            $totalPerKolomTablePerbandingan[$kolom] = round(number_format($perbandinganKriteria->where('criteria_kolom_id', $kolom + 1)->sum('nilai'), 2), 3);
        }

        ////////////////////Normalisasi Table Perbandingan////////////////////////
        $tableNormalisasi = [];
        foreach ($criterias as $baris => $criteria) {
            foreach ($criterias as $kolom => $criteria2) {
                $tableNormalisasi[$baris][$kolom] = round(number_format($tablePerbandinganKriteria[$baris][$kolom] / $totalPerKolomTablePerbandingan[$kolom], 3), 3);
            }
        }



        $totalPerKolomNormalisasiPerbandingan = [];
        foreach ($criterias as $kolom => $criteria) {
            $totalPerKolomNormalisasiPerbandingan[$kolom] = 0;
        }
        foreach ($criterias as $baris => $criteria) {
            foreach ($criterias as $kolom => $criteria2) {
                $totalPerKolomNormalisasiPerbandingan[$kolom] = round(number_format($tableNormalisasi[$baris][$kolom] + $totalPerKolomNormalisasiPerbandingan[$kolom], 2), 3);
            }
        }

        $totalPerRowTableNormalisasi = [];
        foreach ($criterias as $baris => $criteria) {
            $totalPerRowTableNormalisasi[$baris] = 0;
        }
        foreach ($criterias as $baris => $criteria) {
            foreach ($tableNormalisasi[$baris] as $value) {
                $totalPerRowTableNormalisasi[$baris] = round($totalPerRowTableNormalisasi[$baris] + $value, 4);
            }
        }



        ///////////////////////////////Mencari Bobot Kriteria////////////////////////////////////////
        $bobotKriteria = [];
        $eigenValue = [];
        $totalCriteria = $criterias->count();
        foreach ($criterias as $key => $criteria) {
            $bobotKriteria[$key] = round(number_format($totalPerRowTableNormalisasi[$key] / $totalCriteria, 3), 3);
            $eigenValue[$key] = round(number_format($totalPerKolomTablePerbandingan[$key] * $bobotKriteria[$key], 3), 3);
        }
        $totalEigenValue = collect($eigenValue)->sum(); //Lamda Max


        //////////////////////////Mencari Consistency Index////////////////////////////////
        $indexRandomConsistency = [0, 0, 0.58, 0.90, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49];
        $irc = $indexRandomConsistency[$totalCriteria - 1];
        $ci = round(number_format(($totalEigenValue - $totalCriteria) / ($totalCriteria - 1), 3), 3);
        $cr = round(number_format($ci / $irc, 3), 3);


        /////////////////////Perangkingan Menggunakan Metode Waspas//////////////////////////////////

        $alternativeValue = [];
        //Tabel Matrix Keputusan
        foreach ($alternatives as $row => $alternative) {
            foreach ($alternative->criteria as $column => $criteria) {
                $alternativeValue[$column][$row] = $criteria->criteria_value->value;
            }
        }
        ///////////////////////////Normalisasi Matrix Keputusan///////////////////////////// 

        $matrixKeputusanNormalisasi = [];
        foreach ($alternatives as $row => $alternative) {
            foreach ($alternative->criteria as $column => $criteria) {
                // dd($criteria->criteria_value->value);
                $maxValue = max($alternativeValue[$column]);
                $minValue = min($alternativeValue[$column]);
                if ($criteria->type_of_criteria == 'Benefit') {
                    $result = $criteria->criteria_value->value / $maxValue;
                } elseif ($criteria->type_of_criteria == 'Cost  ') {
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
                // dd($criteria);
                $perkalian[$column] =
                    $matrixKeputusanNormalisasi[$column][$row] * $bobotKriteria[$column];
                $perpangkatan[$column] =
                    $matrixKeputusanNormalisasi[$column][$row] ^ $bobotKriteria[$column];
            }
            $totalPenjumlahanRowPerkalian = array_sum($perkalian);
            $totalPerkalianRowPerpangkatan = 0;
            foreach ($perpangkatan as $value) {
                $totalPerkalianRowPerpangkatan = $totalPerkalianRowPerpangkatan * $value;
            }
            $qiValue[$row] = 0.5 * $totalPenjumlahanRowPerkalian + 0.5 * $totalPerkalianRowPerpangkatan;
            $finalResult[$row]['qi'] = $qiValue[$row];
            $finalResult[$row]['name'] = $alternative->name;
        }

        $hasilPerangkingan = collect($finalResult)->sortByDesc('qi');

        return view('responden.hasil', compact('responden', 'alternatives', 'criterias', 'tablePerbandinganKriteria', 'totalPerKolomTablePerbandingan', 'tableNormalisasi', 'totalPerRowTableNormalisasi', 'totalPerKolomNormalisasiPerbandingan', 'bobotKriteria', 'eigenValue', 'ci', 'cr', 'irc', 'alternativeValue', 'matrixKeputusanNormalisasi', 'hasilPerangkingan'));
    }
}

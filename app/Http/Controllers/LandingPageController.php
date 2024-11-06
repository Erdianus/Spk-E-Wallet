<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Respondent;
use App\Models\Alternative;
use Illuminate\Http\Request;
use App\Models\CriteriaWeight;
use Illuminate\Support\Facades\DB;
use App\Models\PerbandinganKriteria;

class LandingPageController extends Controller
{
    public function index()
    {
        $alternatives = Alternative::get();
        $criterias = Criteria::get();
        $nilaiPerbandingan = null;
        $responden = null;
        $hasilPerangkingan = null;
        return view('landing-page', compact('alternatives', 'criterias', 'nilaiPerbandingan', 'responden'));
    }

    public function perhitunganSPK(Request $request)
    {
        // dd($request->all());
        // DB::beginTransaction();
        // try {
        $alternatives = Alternative::get();
        $criterias = Criteria::all();
        $totalKriteria = $criterias->count();
        $message = '';
        $indexRandomConsistency = [0, 0, 0.58, 0.90, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49];
        $alternativeValue = [];
        $responden = Respondent::create([
            'name' => $request->responden,
        ]);
        $nilaiPerbandingan = collect($request->all())->except('responden')->toArray();

        //Tabel Matrix Keputusan
        foreach ($alternatives as $row => $alternative) {
            foreach ($alternative->criteria as $column => $criteria) {
                $alternativeValue[$column][$row] = $criteria->criteria_value->value;
            }
        }

        //Tabel Matrix Perbandingan Berpasangan
        $tablePerbandingan = [];
        $perbandinganKriteria = new PerbandinganKriteria();
        foreach ($criterias as $criteria) {
            foreach ($criterias as $criteria2) {
                if (array_key_exists($criteria2->code . '/' . $criteria->code, $nilaiPerbandingan)) { //check jika array tersebut ada pada $nilaiPerbandingan
                    $parts = explode('-', $nilaiPerbandingan[$criteria2->code . '/' . $criteria->code]);
                    $totalParts = count($parts);
                    if ($totalParts > 1) {
                        $for = $parts[1];
                        $value = $parts[2];
                    } else {
                        $for = 'Both';
                        $value = $parts[0];
                    }
                    if ($for == $criteria->code) {
                        $tablePerbandingan[$criteria->code][$criteria2->code] = $value;
                        $tablePerbandingan[$criteria2->code][$criteria->code] = 1 / $value;
                    } elseif ($for == $criteria2->code) {
                        $tablePerbandingan[$criteria->code][$criteria2->code] = 1 / $value;
                        $tablePerbandingan[$criteria2->code][$criteria->code] = $value;
                    } else {
                        $tablePerbandingan[$criteria->code][$criteria2->code] = $value;
                        $tablePerbandingan[$criteria2->code][$criteria->code] = $value;
                    }
                }
            }
        }
        // dd($tablePerbandingan);

        // dd($tablePerbandingan);
        $totalPerColumnTablePerbandingan = [];
        foreach ($criterias as $criteria) {
            $totalPerColumnTablePerbandingan[$criteria->code] = 0;
        }
        foreach ($criterias as $criteria) {
            foreach ($tablePerbandingan as $value) {
                $totalPerColumnTablePerbandingan[$criteria->code] = $totalPerColumnTablePerbandingan[$criteria->code] + $value[$criteria->code];
            }
        }


        //////////////////////Tabel Normalisasi Kriteria//////////////////////////
        $tableNormalisasi = [];
        foreach ($criterias as $criteria) {
            foreach ($criterias as $criteria2) {
                $tableNormalisasi[$criteria->code][$criteria2->code] = $tablePerbandingan[$criteria->code][$criteria2->code] / $totalPerColumnTablePerbandingan[$criteria2->code];
            }
        }
        $totalPerRowTableNormalisasi = [];
        foreach ($criterias as $criteria) {
            $totalPerRowTableNormalisasi[$criteria->code] = 0;
        }
        foreach ($criterias as $criteria) {
            foreach ($tableNormalisasi[$criteria->code] as $value) {
                $totalPerRowTableNormalisasi[$criteria->code] = $totalPerRowTableNormalisasi[$criteria->code] + $value;
            }
        }


        ///////////////////////BOBOT KRITERIA/////////////////////////////
        $bobotKriteria = [];
        $eigenValue = [];
        foreach ($criterias as $criteria) {
            $bobotKriteria[$criteria->code] = $totalPerRowTableNormalisasi[$criteria->code] / $totalKriteria;
            $eigenValue[$criteria->code] = $totalPerColumnTablePerbandingan[$criteria->code] * $bobotKriteria[$criteria->code];
        }
        $totalEigenValue = collect($eigenValue)->sum(); //Lamda Max


        //////////////////////////Mencari Consistency Index////////////////////////////////
        $ci = ($totalEigenValue - $totalKriteria) / ($totalKriteria - 1);
        $cr = $ci / $indexRandomConsistency[$totalKriteria - 1];
        // dd($cr);
        if ($cr > 0.1) {
            $failed = 'Nilai Perbandingan Anda Belum Konsisten Silahkan Input Ulang Kembali';
            DB::rollBack();
            return back()->with('error', $failed);
        }
        $perbandinganKriteria = new PerbandinganKriteria();
        foreach ($criterias as $criteria) {
            foreach ($criterias as $criteria2) {
                $perbandinganKriteria->create([
                    'responden_id' => $responden->id,
                    'criteria_baris_id' => $criteria->id,
                    'criteria_kolom_id' => $criteria2->id,
                    'nilai' => $tablePerbandingan[$criteria->code][$criteria2->code]
                ]);
            }
        }
        return redirect()->route('hasil-perangkingan', $responden->slug);
    }

    public function hasilPerangkinganSPK(Respondent $responden)
    {
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

        return view('hasil-perangkingan', compact('alternatives', 'criterias', 'tablePerbandinganKriteria', 'totalPerKolomTablePerbandingan', 'tableNormalisasi', 'totalPerRowTableNormalisasi', 'totalPerKolomNormalisasiPerbandingan', 'bobotKriteria', 'eigenValue', 'ci', 'cr', 'irc', 'alternativeValue', 'matrixKeputusanNormalisasi', 'hasilPerangkingan'));
    }
}

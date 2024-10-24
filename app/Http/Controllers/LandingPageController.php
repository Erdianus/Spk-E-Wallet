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
        return redirect()->route('hasil-perangkingan', $responden->id);


        /////////////////////Perangkingan Menggunakan Metode Waspas//////////////////////////////////

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
                    $matrixKeputusanNormalisasi[$column][$row] * $bobotKriteria[$criteria->code];
                $perpangkatan[$column] =
                    $matrixKeputusanNormalisasi[$column][$row] ^ $bobotKriteria[$criteria->code];
            }
            $totalRowPerkalian = array_sum($perkalian);
            $totalRowPerpangkatan = array_sum($perpangkatan);
            $qiValue[$row] = 0.5 * $totalRowPerkalian + 0.5 * $totalRowPerpangkatan;
            $finalResult[$row]['qi'] = $qiValue[$row];
            $finalResult[$row]['name'] = $alternative->name;
        }
        $hasilPerangkingan = collect($finalResult)->sortByDesc('qi');
        // dd($hasilPerangkingan)
        DB::commit();
        return redirect()->route('hasil-perangkingan', $responden);
        // } catch (\Throwable $e) {
        //     $failed = 'Sepertinya ada yang salah';
        //     DB::rollBack();
        //     return redirect()->back()->with('error', $e->getMessage());
        // }
    }

    public function hasilPerangkinganSPK(Respondent $responden)
    {
        dd($responden);

        //     $perbandinganKriteria = PerbandinganKriteria::where('responden_id', $responden->id)->get();
        //     $alternatives = Alternative::get();
        //     $criterias = Criteria::all();
        //     $totalPerColumnTablePerbandingan = [];
        //     foreach ($criterias as $criteria) {
        //         $totalPerColumnTablePerbandingan[$criteria->code] = 0;
        //     }
        //     foreach ($criterias as $criteria) {
        //         foreach ($tablePerbandingan as $value) {
        //             $totalPerColumnTablePerbandingan[$criteria->code] = $totalPerColumnTablePerbandingan[$criteria->code] + $value[$criteria->code];
        //         }
        //     }


        //     //////////////////////Tabel Normalisasi Kriteria//////////////////////////
        //     $tableNormalisasi = [];
        //     foreach ($criterias as $criteria) {
        //         foreach ($criterias as $criteria2) {
        //             $tableNormalisasi[$criteria->code][$criteria2->code] = $tablePerbandingan[$criteria->code][$criteria2->code] / $totalPerColumnTablePerbandingan[$criteria2->code];
        //         }
        //     }
        //     $totalPerRowTableNormalisasi = [];
        //     foreach ($criterias as $criteria) {
        //         $totalPerRowTableNormalisasi[$criteria->code] = 0;
        //     }
        //     foreach ($criterias as $criteria) {
        //         foreach ($tableNormalisasi[$criteria->code] as $value) {
        //             $totalPerRowTableNormalisasi[$criteria->code] = $totalPerRowTableNormalisasi[$criteria->code] + $value;
        //         }
        //     }


        //     ///////////////////////BOBOT KRITERIA/////////////////////////////
        //     $bobotKriteria = [];
        //     $eigenValue = [];
        //     foreach ($criterias as $criteria) {
        //         $bobotKriteria[$criteria->code] = $totalPerRowTableNormalisasi[$criteria->code] / $totalKriteria;
        //         $eigenValue[$criteria->code] = $totalPerColumnTablePerbandingan[$criteria->code] * $bobotKriteria[$criteria->code];
        //     }
        //     $totalEigenValue = collect($eigenValue)->sum(); //Lamda Max


        //     //////////////////////////Mencari Consistency Index////////////////////////////////
        //     $ci = ($totalEigenValue - $totalKriteria) / ($totalKriteria - 1);
        //     $cr = $ci / $indexRandomConsistency[$totalKriteria - 1];

        //     if ($cr > 0.1) {
        //         $failed = 'Nilai Perbandingan Anda Belum Konsisten Silahkan Input Ulang Kembali';
        //         DB::rollBack();
        //         return back()->with('error', $failed);
        //     }
    }
}

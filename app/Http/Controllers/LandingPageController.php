<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Alternative;
use Illuminate\Http\Request;
use App\Models\CriteriaWeight;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $alternatives = Alternative::get();
        $criterias = Criteria::all();
        $alternativeValue = [];
        $matrixKeputusanNormalisasi = [];
        // $bobotKriteria = [];
        // dd($request->all());
        if ($request) {
            $nilaiPerbandingan = collect($request->all())->except('responden')->toArray();
            $responden = $request->responden;

            //Tabel Matrix Keputusan
            foreach ($alternatives as $row => $alternative) {
                // $weights = CriteriaWeight::where('respondent_id')->get();
                foreach ($alternative->criteria as $column => $criteria) {
                    //dd($criteria);
                    $alternativeValue[$column][$row] = $criteria->criteria_value->value;
                }
            }

            //Tabel Matrix Perbandingan Berpasangan
            $tablePerbandingan = [];
            foreach ($criterias as $criteria) {
                foreach ($criterias as $criteria2) {
                    // dd(array_key_exists($criteria2->code . '/' . $criteria->code, $nilaiPerbandingan));
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
                            $tablePerbandingan[$criteria2->code][$criteria->code] = $value;
                            $tablePerbandingan[$criteria->code][$criteria2->code] = $value;
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
            dd($totalPerColumnTablePerbandingan);

            //Tabel Normalisasi Kriteria
            $tableNormalisasi = [];
            foreach ($criterias as $criteria) {
                foreach ($criterias as $criteria2) {
                    $tableNormalisasi[$criteria->code][$criteria2->code] = $tablePerbandingan[$criteria->code][$criteria2->code] / $totalPerColumnTablePerbandingan[$criteria2->code];
                }
            }
            // dd($tableNormalisasi);




            foreach ($alternatives as $row => $alternative) {
                foreach ($alternative->criteria as $column => $criteria) {
                    $maxValue = max($alternativeValue[$column]);
                    $minValue = min($alternativeValue[$column]);
                    if ($criteria->type_of_criteria == 'Benefit') {
                        $result = $criteria->criteria_value->value / $maxValue;
                    } elseif ($criteria->type_of_criteria == 'Cost') {
                        $result = $minValue / $criteria->criteria_value->value;
                    }
                    $matrixKeputusanNormalisasi[$column][$row] = $result;
                }
            }
            // dd($matrixKeputusanNormalisasi);



            // //Perhitungan Nilai Qi
            // $qiValue = [];
            // $finalResult = [];
            // foreach ($alternatives as $row => $alternative) {
            //     $perkalian = [];
            //     $perpangkatan = [];
            //     foreach ($criterias as $column => $criteria) {
            //         // dd($criteria);
            //         $perkalian[$column] =
            //             $matrixKeputusanNormalisasi[$column][$row] * $criteria->weight->weight;
            //         $perpangkatan[$column] =
            //             $matrixKeputusanNormalisasi[$column][$row] ^ $criteria->weight->weight;
            //     }
            //     $totalRowPerkalian = array_sum($perkalian);
            //     $totalRowPerpangkatan = array_sum($perpangkatan);
            //     $qiValue[$row] = 0.5 * $totalRowPerkalian + 0.5 * $totalRowPerpangkatan;
            //     $finalResult[$row]['qi'] = $qiValue[$row];
            //     $finalResult[$row]['name'] = $alternative->name;
            // }
            // $hasilPerangkingan = collect($finalResult)->sortByDesc('qi');
        } else {
            $nilaiPerbandingan = null;
            $responden = null;
            $hasilPerangkingan = null;
        }

        //dd($nilaiPerbandingan);


        return view('landing-page', compact('alternatives', 'criterias', 'nilaiPerbandingan', 'responden'));
    }
}

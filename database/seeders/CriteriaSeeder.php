<?php

namespace Database\Seeders;

use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $criterias = [
            'Tampilan UI/UX',
            'Metode Top Up',
            'Rating Aplikasi',
            'Promo',
            'Merchant',
            'Security',
            'Premium Account Benefit'
        ];
        foreach ($criterias as $key => $value) {
            Criteria::create([
                'code' => "C" . $key,
                'name' => $value,
                'type_of_criteria' => 'Benefit'
            ]);
        }
        $items = Criteria::get();
        $subCriterias = ['Buruk', 'Cukup', 'Cukup Baik', 'Baik', 'Sangat Baik'];
        foreach ($items as $criteria) {
            foreach ($subCriterias as $key => $subCriteria) {
                SubCriteria::create([
                    'name' => $subCriteria,
                    'value' => $key + 1,
                    'criteria_id' => $criteria->id,
                ]);
            }
        }
    }
}

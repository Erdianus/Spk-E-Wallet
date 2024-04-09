<?php

namespace Database\Seeders;

use App\Models\Criteria;
use App\Models\PerbandinganKriteria;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PerbandinganCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $criterias = Criteria::get();
        foreach ($criterias as $criteria) {
            PerbandinganKriteria::create([
                'criteria1_id' => $criteria->id,
                'criteria2_id' => $criteria->id,
                'weight' => 1,
                'for_criteria' => $criteria->id
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Respondent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RespondenSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $respondens = Respondent::get();
        foreach ($respondens as $responden) {
            $responden->update([
                'slug' => $responden->generateUniqueSlug($responden->name)
            ]);
        }
    }
}

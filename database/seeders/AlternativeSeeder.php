<?php

namespace Database\Seeders;

use App\Models\Alternative;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlternativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $e_wallet = ['ShoopePay', 'Gopay', 'OVO', 'DANA', 'LinkAja', 'Jenius'];
        foreach ($e_wallet as $value) {
            Alternative::create([
                'name' => $value
            ]);
        }
    }
}

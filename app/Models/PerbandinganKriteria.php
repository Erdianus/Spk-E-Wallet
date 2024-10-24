<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerbandinganKriteria extends Model
{
    use HasFactory;

    protected $table = 'perbandingan_kriterias';
    protected $fillable = [
        'criteria_baris_id',
        'criteria_kolom_id',
        'responden_id',
        'nilai',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerbandinganKriteria extends Model
{
    use HasFactory;

    protected $table = 'perbandingan_criteria';
    protected $fillable = [
        'criteria1_id',
        'criteria2_id',
        'for_criteria',
        'weight',
    ];
}

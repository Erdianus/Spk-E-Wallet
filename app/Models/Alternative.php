<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function criteria()
    {
        return $this->belongsToMany(Criteria::class, 'alternative_criteria', 'alternative_id', 'criteria_id')
            ->withPivot(['value'])
            ->withTimestamps();
    }
}

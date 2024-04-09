<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type_of_criteria',
    ];

    public function subCriteria()
    {
        return $this->hasMany(SubCriteria::class, 'criteria_id', 'id');
    }

    public function weight()
    {
        return $this->hasOne(CriteriaWeight::class, 'criteria_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Respondent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function booted()
    {
        static::creating(function ($project) {
            $project->slug = self::generateUniqueSlug($project->name);
        });

        static::updating(function ($project) {
            if ($project->isDirty('name')) {
                $project->slug = self::generateUniqueSlug($project->name);
            }
        });
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (Respondent::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }

    public function perbandinganKriteria()
    {
        return $this->hasMany(PerbandinganKriteria::class, 'responden_id', 'id');
    }
}

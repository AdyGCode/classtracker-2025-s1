<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clusters extends Model
{
    /** @use HasFactory<\Database\Factories\ClustersFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'qualification',
        'qualification_code',
        'unit_1',
        'unit_2',
        'unit_3',
        'unit_4',
        "unit_5",
        "unit_6",
        "unit_7",
        "unit_8",
    ];

    public function course()
    {
        return $this->belongsTo(Courses::class);
    }


    public function unit()
    {
        return $this->hasMany(Units::class);
    }
}

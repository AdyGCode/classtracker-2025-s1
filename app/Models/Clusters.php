<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clusters extends Model
{
    /** @use HasFactory<\Database\Factories\ClustersFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'code',
        'title',
        'qualification',
        'qualification_code',
        'unit_1',
        'unit_2',
        'unit_3',
        'unit_4',
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    /** @use HasFactory<\Database\Factories\UnitsFactory> */
    use HasFactory;

    protected $fillable = [
        'national_code',
        'aqf_level',
        'title',
        'tga_status',
        'state_code',
        'nominal_hours',
        'type',
        'qa',
    ];

    public  function parent()
    {
        return $this->belongsTo(Clusters::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    /** @use HasFactory<\Database\Factories\CoursesFactory> */
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

    /**
     * Define a relationship to the parent
     */

    public  function parent()
    {
        return $this->belongsTo(Packages::class);
    }

    public function cluster()
    {
        return $this->hasMany(Clusters::class);
    }
}

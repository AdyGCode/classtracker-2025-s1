<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cluster extends Model
{
    /** @use HasFactory<\Database\Factories\ClusterFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'qualification',
        'qualification_code',
        'unit_id',
        'unit_1',
        'unit_2',
        'unit_3',
        'unit_4',
        'unit_5',
        'unit_6',
        'unit_7',
        'unit_8',
        'unit_id',

    ];



//    public function courses():BelongsTo
//    {
//        return $this->belongsTo(Course::class);
//    }


    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function lesson()
    {
        return $this->hasMany(Lesson::class);
    }
}

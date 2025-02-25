<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    /** @use HasFactory<\Database\Factories\PackagesFactory> */
    use HasFactory;

    protected $fillable = [
        'national_code',
        'title',
        'tga_status',
    ];

    public function course()
    {
        return $this->hasMany(Courses::class);
    }
}

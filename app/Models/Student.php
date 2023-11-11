<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'terlambat',
        'alfa'
    ];

    // public function rAbsen()
    // {
    //     return $this->hasMany(Absen::class, 'absen_id');
    // }
}

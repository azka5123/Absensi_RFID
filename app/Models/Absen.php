<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'jam_masuk',
        'jam_keluar',
        'keterangan'
    ];


    public function rStudent()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'full_name',
        'gender',
        'course',
        'section',
        'birthdate',
        'contact_number',
        'address',
        'guardian_name',
        'emergency_contact'
    ];

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
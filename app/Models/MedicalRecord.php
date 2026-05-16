<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalRecord extends Model
{
    use HasFactory;

    public const STATUSES = [
        'Healthy',
        'Under Observation',
        'Needs Attention',
        'Critical',
    ];

    protected $fillable = [
        'student_id',
        'checkup_date',
        'height',
        'weight',
        'blood_pressure',
        'allergies',
        'medical_condition',
        'diagnosis',
        'treatment',
        'prescribed_medicine',
        'notes',
        'medical_status',
        'file_attachment',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Student;

class HealthReportController extends Controller
{
    public function index()
    {
        $statusCounts = collect(MedicalRecord::STATUSES)->mapWithKeys(function ($status) {
            return [$status => MedicalRecord::where('medical_status', $status)->count()];
        });

        $totalRecords = MedicalRecord::count();
        $totalStudents = Student::count();
        $studentsWithRecords = Student::has('medicalRecords')->count();

        $needsAttention = MedicalRecord::with('student')
            ->whereIn('medical_status', ['Critical', 'Needs Attention', 'Under Observation'])
            ->orderByDesc('checkup_date')
            ->limit(10)
            ->get();

        return view('reports.health-summary', compact(
            'statusCounts',
            'totalRecords',
            'totalStudents',
            'studentsWithRecords',
            'needsAttention'
        ));
    }
}

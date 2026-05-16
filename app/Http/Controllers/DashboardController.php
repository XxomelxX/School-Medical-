<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\MedicalRecord;
use App\Models\Student;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        if (session('user_role') === 'student') {
            return $this->studentDashboard();
        }

        return view('dashboard', [
            'students' => Student::count(),
            'records' => MedicalRecord::count(),
            'healthyCount' => MedicalRecord::where('medical_status', 'Healthy')->count(),
            'attentionCount' => MedicalRecord::whereIn('medical_status', ['Critical', 'Needs Attention', 'Under Observation'])->count(),
            'recentRecords' => MedicalRecord::with('student')->orderByDesc('checkup_date')->limit(5)->get(),
            'recentActivity' => ActivityLog::latest()->limit(8)->get(),
        ]);
    }

    protected function studentDashboard()
    {
        $user = User::with('student')->findOrFail(session('user_id'));
        $student = $user->student;

        if (! $student) {
            return view('dashboard-student', [
                'student' => null,
                'records' => collect(),
            ]);
        }

        $records = $student->medicalRecords()->orderByDesc('checkup_date')->get();

        return view('dashboard-student', [
            'student' => $student,
            'records' => $records,
            'latestRecord' => $records->first(),
        ]);
    }
}

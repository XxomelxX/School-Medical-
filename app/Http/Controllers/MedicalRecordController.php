<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedicalRecordRequest;
use App\Http\Requests\UpdateMedicalRecordRequest;
use App\Models\MedicalRecord;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        if (session('user_role') === 'student') {
            return redirect()->route('dashboard');
        }

        $search = $request->search;
        $status = $request->status;

        $records = MedicalRecord::with('student')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('student', function ($query) use ($search) {
                    $query->where('full_name', 'like', "%{$search}%")
                        ->orWhere('student_id', 'like', "%{$search}%");
                });
            })
            ->when($status, fn ($query) => $query->where('medical_status', $status))
            ->orderByDesc('checkup_date')
            ->paginate(10);

        $statuses = MedicalRecord::STATUSES;

        return view('medical_records.index', compact('records', 'search', 'status', 'statuses'));
    }

    public function create()
    {
        $students = Student::orderBy('full_name')->get();
        $selectedStudentId = old('student_id', request('student_id'));

        return view('medical_records.create', compact('students', 'selectedStudentId'));
    }

    public function store(StoreMedicalRecordRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('file_attachment')) {
            $validated['file_attachment'] = $request->file('file_attachment')
                ->store('medical_files', 'public');
        }

        MedicalRecord::create($validated);

        return redirect()->route('medical-records.index')
            ->with('success', 'Medical record added successfully.');
    }

    public function show(MedicalRecord $medicalRecord)
    {
        $this->authorizeRecordAccess($medicalRecord);

        return view('medical_records.show', compact('medicalRecord'));
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        $students = Student::orderBy('full_name')->get();

        return view('medical_records.edit', compact('medicalRecord', 'students'));
    }

    public function update(UpdateMedicalRecordRequest $request, MedicalRecord $medicalRecord)
    {
        $validated = $request->validated();

        if ($request->hasFile('file_attachment')) {
            if ($medicalRecord->file_attachment) {
                Storage::disk('public')->delete($medicalRecord->file_attachment);
            }

            $validated['file_attachment'] = $request->file('file_attachment')
                ->store('medical_files', 'public');
        }

        $medicalRecord->update($validated);

        return redirect()->route('medical-records.show', $medicalRecord)
            ->with('success', 'Medical record updated successfully.');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        if ($medicalRecord->file_attachment) {
            Storage::disk('public')->delete($medicalRecord->file_attachment);
        }

        $medicalRecord->delete();

        return redirect()->route('medical-records.index')
            ->with('success', 'Medical record deleted successfully.');
    }

    public function exportPdf($id)
    {
        $record = MedicalRecord::with('student')->findOrFail($id);
        $this->authorizeRecordAccess($record);

        $pdf = Pdf::loadView('medical_records.pdf', compact('record'));

        return $pdf->download('medical_record_' . $record->id . '.pdf');
    }

    protected function authorizeRecordAccess(MedicalRecord $record): void
    {
        if (session('user_role') === 'student' && (int) session('student_id') !== (int) $record->student_id) {
            abort(403, 'You can only view your own medical records.');
        }
    }
}

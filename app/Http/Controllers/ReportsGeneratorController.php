<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\ProfessorCourse;
use App\Models\ProfessorGraduateSupervision;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportsGeneratorController extends Controller
{
    public function show()
    {
        $report_types = [
            [
                'id' => 0,
                'value' => 'Professors Report'
            ],
            [
                'id' => 1,
                'value' => 'Teaching Assistants Report'
            ],
            [
                'id' => 2,
                'value' => 'Courses Report'
            ],
            [
                'id' => 3,
                'value' => 'Topics Report'
            ],
            [
                'id' => 4,
                'value' => 'Program Report'
            ],
            [
                'id' => 5,
                'value' => 'Subjects Report'
            ],
            [
                'id' => 6,
                'value' => 'Publications Report'
            ],
        ];
        $formats = ['pdf', 'docx'];

        return view('pages/reports-generator.index', compact('report_types', 'formats'));
    }

    public function generateReport(Request $request)
    {
        try {
            $title = 'professors-report';
           $pdf = $this->generate($request->all(), $title);
           return $pdf;
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while generating the PDF.');
        }
    }

    public function generate($requestData, $title)
    {
        $presets = [
            0 => [ 'title' => 'professors-report', 'data' => Professor::where('workspace_id', Auth::user()->workspace_id)->get()],
            1 => [ 'title' => 'teaching-assistants-report', 'data' => ProfessorGraduateSupervision::whereHas('professor', function($query) {
                $query->where('workspace_id', Auth::user()->workspace_id);
            })->with(['professor', 'studyProgram', 'supervisionStatus', 'supervisionRole'])->get()],
            2 => [ 
                'title' => 'courses-report', 
                'data' => ProfessorCourse::whereHas('professor', function($query) {
                    $query->where('workspace_id', Auth::user()->workspace_id);
                })->with(['courseCredit', 'courseProgram', 'courseTopic', 'professor'])->get()
            ],
            3 => [ 
                'title' => 'topics-report', 
                'data' => ProfessorCourse::whereHas('professor', function($query) {
                    $query->where('workspace_id', Auth::user()->workspace_id);
                })->with(['courseTopic', 'courseTopic.subject'])->get()
            ],
            4 => [ 
                'title' => 'program-report', 
                'data' => ProfessorCourse::whereHas('professor', function($query) {
                    $query->where('workspace_id', Auth::user()->workspace_id);
                })->with(['courseProgram'])->get()
            ],
            5 => [ 
                'title' => 'subjects-report', 
                'data' => ProfessorCourse::whereHas('professor', function($query) {
                    $query->where('workspace_id', Auth::user()->workspace_id);
                })->with(['courseTopic.subject'])->get()
            ],
            6 => [ 
                'title' => 'publications-report', 
                'data' => Professor::where('workspace_id', Auth::user()->workspace_id)->get()
            ],
        ];
        $title = $presets[$requestData['report_type']]['title'];
        $data = $presets[$requestData['report_type']]['data'];
        
        $pdf = Pdf::loadView('pages/reports-generator.report-templates.' . $title, compact('data'));
        return $pdf->download($title . '_' . Carbon::now()->format('Y-m-d') . '.pdf');
    }
}

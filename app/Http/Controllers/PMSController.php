<?php

namespace App\Http\Controllers;

use App\Authorizable;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\User;
use App\Models\PatientEncounter;
use App\Models\EncounterMedicalReport;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Auth;

class PMSController extends Controller
{
     // use Authorizable;
    protected string $exportClass = '\App\Exports\CustomerExport';

    public function __construct()
    {
       $this->module_title = 't.PME';

       view()->share([
            'module_title' => $this->module_title,
            
        ]); 
    }

    public function index(Request $request)
    {
       $patients = User::where('user_type','user')->orderBy('first_name')->get();
       return view('backend.PMS.index',compact('patients')); 
    }

    public function show($id)
    {
        $patient = User::with('encounterMedicalReports')->findOrFail($id);
        return view('backend.PMS.view', compact('patient'));
    }
    public function upload(Request $request)
    {
       $request->validate([
        'doc_files' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
       ]);

       $patient = User::findOrFail($request->get('id'));

       $file = $request->file('doc_files');

        $filename = time().'_'.$file->getClientOriginalName();  // Generate a unique file name
        $path = 'patient_files/' . $filename;

        $file->move(public_path('patient_files'), $filename);

       // Create a new EncounterMedicalReport entry with the uploaded file
       $patient->encounterMedicalReports()->create([
          'user_id' => $patient->id,
          'name' => 'Medical Report',
          'date' => now(),
          'doc_files' => $path,
       ]);

        return redirect()->back()->with('success', 'File uploaded successfully.');
    }
    public function missingFiles()
    {
        $reports = EncounterMedicalReport::whereNull('doc_files')->get();
        return view('backend.resultUpload.index', compact('reports'));
    }
    public function uploadPending(Request $request)
    {
       
        $request->validate([
        'doc_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $report_id = $request->get('report_id');

        // Get the uploaded file
        $file = $request->file('doc_file');

        // Define the file name and path
        $filename = time().'_'.$file->getClientOriginalName();  // Generate a unique file name
        $path = 'patient_files/' . $filename;

        // Move the file to the public folder
        $file->move(public_path('patient_files'), $filename);

        // Update the database record with the new file path
        EncounterMedicalReport::where('id', '=', $report_id)
                          ->update(['doc_files' => $path]);

        return redirect()->back()->with('success', 'File uploaded successfully.');

    }



}

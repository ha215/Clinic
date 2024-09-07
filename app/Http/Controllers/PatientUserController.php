<?php

namespace App\Http\Controllers;

use App\Authorizable;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\PatientEncounter;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Customer\Http\Requests\CustomerRequest;
use Modules\CustomField\Models\CustomField;
use Modules\CustomField\Models\CustomFieldGroup;
use Yajra\DataTables\DataTables;
use Auth;
use App\Imports\PatientsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Nationality;

class PatientUserController extends Controller
{
     // use Authorizable;
    protected string $exportClass = '\App\Exports\CustomerExport';

    public function __construct()
    {
        // Page Title
        $this->module_title = 't.Patient Management';

        // module name
        $this->module_name = 'customers';

        // directory path of the module
        $this->module_path = 'customer::backend';

        view()->share([
            'module_title' => $this->module_title,
            'module_icon' => 'fa-regular fa-sun',
            'module_name' => $this->module_name,
            'module_path' => $this->module_path,
        ]);
        $this->middleware(['permission:view_customer'])->only('index');
        $this->middleware(['permission:edit_customer'])->only('edit', 'update');
        $this->middleware(['permission:add_customer'])->only('store');
        $this->middleware(['permission:delete_customer'])->only('destroy');
    }

    
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('filter_type') && $request->has('search_query')) {
           switch ($request->filter_type) {
            case 'age':
                $query->where('age', $request->search_query);
                break;
            case 'nationality':
                $query->where('nationality', 'like', '%' . $request->search_query . '%');
                break;
            case 'civil_id':
                $query->where('civil_id', 'like', '%' . $request->search_query . '%');
                break;
            case 'name':
                $query->where('name', 'like', '%' . $request->search_query . '%');
                break;
            }
        }

        $patients = $query->where('user_type','user')->paginate(10); // Adjust the number as needed
        
        if ($request->ajax()) {
            return view('backend.patients.partials.patient_table', compact('patients'))->render();
        }

         return view('backend.patients.index', compact('patients'));
    }
    public function import(Request $request)
    {
        $request->validate([
            'patient_import' => 'required|file|mimes:csv,txt',
        ]);

        Excel::import(new PatientsImport, $request->file('patient_import'));

        return redirect()->route('user_list')->with('success', __('t.Patients imported successfully.'));
    }

    public function create()
    {
        $departments = Department::where('patient','=','Y')->orderBy('name')->get();
        $nationalities = Nationality::orderBy('name')->get();
        return view('backend.patients.create',compact('departments','nationalities'));
    }

    public function store(Request $request) {
    
        User::create(['first_name' => $request->get('name'), 
                  'last_name' => $request->get('name'),
                     'email' => $request->get('email'),
                     'mobile' => $request->get('mobile_number'),
                     'gender' => $request->get('sex'),
                     'date_of_birth' => $request->get('date_of_birth'),
                     'departments_id' => $request->get('department'),
                     'civil_id' => $request->get('civil_id'),
                     'employee_id' => $request->get('employee_id'),
                     'user_type' => 'user',
                     'nationality' => $request->get('Nationality'),
                     'created_by' => Auth::user()->id,
                     'pme_month' => $request->get('month'),
                     'pme_year' => $request->get('year'),
            ]);
        return redirect()->route('user_list');
    }

    public function edit($id) {
       $patient = User::findOrFail($id);
       $departments = Department::where('patient','=','Y')->orderBy('name')->get();
       $nationalities = Nationality::orderBy('name')->get();
       return view('backend.patients.edit', compact('patient','departments','nationalities'));
    }

    public function update(Request $request) {
    
        $patient = User::findOrFail($request->get('patient_id'));
        $patient->update(['first_name' => $request->get('name'),
                     'last_name' => $request->get('name'),
                     'email' => $request->get('email'),
                     'mobile' => $request->get('mobile_number'),
                     'gender' => $request->get('sex'),
                     'date_of_birth' => $request->get('date_of_birth'),
                     'departments_id' => $request->get('department'),
                     'civil_id' => $request->get('civil_id'),
                     'employee_id' => $request->get('employee_id'),
                     'user_type' => 'user',
                     'nationality' => $request->get('Nationality'),
                     'created_by' => Auth::user()->id,
                     'pme_month' => $request->get('month'),
                     'pme_year' => $request->get('year'),
            ]);

        return redirect()->route('user_list');
    }

    public function view($id) {
       $patient = User::findOrFail($id);
       $appointmentList = PatientEncounter::where('user_id',$id)->orderBy('encounter_date','desc')->get();
       return view('backend.patients.view', compact('patient','appointmentList'));
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Service;
use App\Models\Department;
use App\Models\DoctorServiceMapping;
use Auth;


class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->module_title = 't.Doctors';

        view()->share([
            'module_title' => $this->module_title,
            
        ]); 

       
    }

    public function index()
    {
        $doctors = User::where('user_type','doctor')->orderBy('first_name')->get();

        return view('backend.doctors.index', compact('doctors'));
    }

    public function create()
    {
         $departments = Department::all(); 
         $services = Service::all(); 
         $departments = Department::orderBy('name')->get();
         return view('backend.doctors.create', compact('departments', 'services','departments'));
    }

    public function store(Request $request) {
    

        $doctor =   User::create(['first_name' => $request->get('name'),
                           'email' => $request->get('email'),
                           'mobile' => $request->get('mobile_number'),
                           'gender' => $request->get('sex'),
                           'date_of_birth' => $request->get('date_of_birth'),
                           'departments_id' => $request->get('department'),
                           'civil_id' => $request->get('civil_id'),
                           'employee_id' => Auth::user()->id,
                           'user_type' => 'doctor',
            ]);
        Doctor::create(['doctor_id'  => $doctor->id,
                        'created_by' => Auth::user()->id ]);
        foreach($request['services'] as $service){
             DoctorServiceMapping::create(['doctor_id'  => $doctor->id,
                                      'clinic_id'  => 1,
                                      'service_id' => $service,
                                      'charges'    => 100,
                                      'created_by' => Auth::user()->id ]);
        }
       
        return redirect()->route('doctor-list');
    }

    
}

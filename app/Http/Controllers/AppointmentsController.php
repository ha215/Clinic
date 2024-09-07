<?php

namespace App\Http\Controllers;

use App\Authorizable;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\User;
use App\Models\PatientEncounter;
use App\Models\EncounterPrescription;
use App\Models\EncounterMedicalReport;
use App\Models\EncounterMedicalProblems;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Auth;
use App\Models\TimeSlot;
use App\Models\DoctorHoliday;
use Illuminate\Support\Arr;
use App\Models\ClinicsService;
use App\Models\Clinics;
use App\Models\Nationality;

class AppointmentsController extends Controller
{
     // use Authorizable;
    protected string $exportClass = '\App\Exports\CustomerExport';

    public function __construct()
    {
       $this->module_title = 't.mangement';

       view()->share([
            'module_title' => $this->module_title,
            
        ]);
        
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
        $query = Appointment::with(['patient', 'doctor', 'department']);

        if ($request->filled('civil_id')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('appointment_date', $request->civil_id);
            });
        }
        if ($request->filled('filter_type') && $request->filled('name')) {
            if ($request->filter_type == 'department') {
                $query->whereHas('department', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->name . '%');
                });
            } elseif ($request->filter_type == 'doctor') {
                $query->whereHas('doctor', function ($q) use ($request) {
                    $q->where('first_name', 'like', '%' . $request->name . '%');
                });
            }
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        } else {
            $query->whereDate('appointment_date', now());
        }

        return DataTables::of($query)
            ->addColumn('civil_id', function ($appointment) {
                return $appointment->patient->civil_id;
            })
            ->addColumn('first_name', function ($appointment) {
                return $appointment->patient->first_name;
            })
            ->addColumn('mobile_number', function ($appointment) {
                return $appointment->patient->mobile;
            })
            ->addColumn('department', function ($appointment) {
                return $appointment->department->name;
            })
            ->addColumn('doctor', function ($appointment) {
                return $appointment->doctor->first_name;
            })
            ->addColumn('appointment_time', function ($appointment) {
                return $appointment->appointment_time;
            })
            ->make(true);
    }

    return view('backend.appointments.index');
    }
    public function create()
    {
        $departments = Department::where('patient','=','N')->orderBy('name')->get();
        $doctors = User::where('user_type','doctor')->orderBy('first_name')->get();
        $services = ClinicsService::orderBy('name')->get();
        $nationalities = Nationality::orderBy('name')->get();
       return view('backend.appointments.create',compact('departments','doctors','services','nationalities'));
    }

    public function store(Request $request) {
    $request->validate([
        'patient_id' => 'required',
        'appointment_date' => 'required',
        'service' => 'required',
        'doctor_id' => 'required',
    ]);

    $appointmentTime = $request->get('appointment_time'); 
    $appointmentDate = $request->get('appointment_date');

    $startTime = explode(' - ', $appointmentTime)[0];

    $combinedDateTime = Carbon::createFromFormat('Y-m-d h:i A', $appointmentDate . ' ' . $startTime);
    $user = User::find($request->get('patient_id'));

    $appointment = Appointment::create(['user_id' => $request->get('patient_id'),
                         'doctor_id' => $request->get('doctor_id'),
                         'departments_id' =>  $request->get('department_id'),
                         'appointment_date' => $request->get('appointment_date'),
                         'appointment_time' => $request->get('appointment_time'),
                         'room' => $request->get('room_number'),
                         'service_id' => $request->get('service'),
                         'total_amount' => 10,
                         'service_amount' => 10,
                         'service_price'  => 10,
                         'clinic_id'   => 1,
                         'start_date_time' => $combinedDateTime,
                        
            ]);
    PatientEncounter::create(['encounter_date' => $request->get('appointment_date'),
                              'user_id'  => $request->get('patient_id'),
                              'clinic_id' => 1,
                              'doctor_id' => $request->get('doctor_id'),
                              'appointment_id' => $appointment->id,
                              ]);
    return redirect()->route('appoinment-list')->with('success', 'Inserted Successfully!');;
    }

    public function Patientindex()
    {
        $doctor_id = auth()->user()->id;

        // Total number of patients (unique users)
        $totalPatients = Appointment::where('doctor_id', $doctor_id)
            ->distinct('user_id')
            ->count('user_id');

        // Get all appointments with filtering by date
        if(Auth::user()->user_type == 'doctor'){
            $appointments = Appointment::where('doctor_id', $doctor_id)
            ->where('status','check_in')
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);
        }else{
            $appointments = Appointment::orderBy('appointment_date', 'desc')
                                       ->paginate(10);
        }
        

        return view('backend.appointments.patient_list', compact('totalPatients', 'appointments'));
    }
    public function encounterDetails($id)
    {
        $appointment = Appointment::with(['patient', 'doctor'])
            ->findOrFail($id);
        $patient = User::find($appointment->patient->id);
        $encounter = PatientEncounter::where('appointment_id',$id)->first();
        $tests = EncounterMedicalReport::where('encounter_id',$encounter->id)->get();
        $medicines = EncounterPrescription::where('encounter_id',$encounter->id)->get();
        $diseases = EncounterMedicalProblems::where('encounter_id',$encounter->id)->get();
        $appointmentList = PatientEncounter::where('user_id',$appointment->patient->id)->orderBy('encounter_date','desc')->get();
        return view('backend.appointments.encounter_details', compact('appointment','patient','medicines','encounter','tests','diseases','appointmentList'));
    }
    public function getCivil(Request $request)
    {
        $user  = User::where('civil_id',$request->get('civil_id'))->first();
        return $user;
    }
    public function getDepartment(Request $request)
    {
        $user  = User::where('departments_id',$request->get('department_id'))->get();
        return $user;
    }
    public function saveMedicine(Request $request)
    {
        EncounterPrescription::create(['encounter_id' => $request->get('patient_encounter_id'),
                              'user_id'  => $request->get('user_id'),
                              'name' => $request->get('medicine_name'),
                              'frequency' => $request->get('frequency'),
                              'duration' => $request->get('duration'),
                              'instruction' => $request->get('instruction'),
                              ]);
        session(['last_section' => 'medicine']);
        return redirect()->route('doctor.appointment.encounter', ['id' => $request->get('appoint_id')]);
    }
    public function saveTest(Request $request)
    {
        EncounterMedicalReport::create(['encounter_id' => $request->get('patient_encounter_id'),
                              'user_id'  => $request->get('user_id'),
                              'name' => $request->get('test_name'),
                              'date' => now(),
                            ]);
        session(['last_section' => 'test']);
        return redirect()->route('doctor.appointment.encounter', ['id' => $request->get('appoint_id')]);
    }
    public function saveDisease(Request $request)
    {
        EncounterMedicalProblems::create(['encounter_id' => $request->get('patient_encounter_id'),
                              'user_id'  => $request->get('user_id'),
                              'problem' => $request->get('problem'),
                              'observation' => $request->get('observation'),
                              'note' => $request->get('note'),
                              'created_by' => Auth::user()->id,
                            ]);
        session(['last_section' => 'disease']);
        return redirect()->route('doctor.appointment.encounter', ['id' => $request->get('appoint_id')]);
    }
    public function UpdateStatus(Request $request)
    {
        $appointment = Appointment::findOrFail($request->get('appointment_id'));
        $appointment->update(['status' => $request->get('status'),
                            ]);
         return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }
    public function PMBStatus(Request $request)
    {
        $patient = User::findOrFail($request->get('patientId'));
        $patient->update(['Is_PMS' => 'Y',
                            ]);
         return response()->json(['success' => true, 'message' => 'Updated successfully.']);
    }
    public function getAvailableTimes(Request $request)
    {
        $doctorId = $request->doctor_id;
        $date = $request->appointment_date;

        // Check if the doctor is on leave
        $isDoctorOnLeave = DoctorHoliday::where('doctor_id', $doctorId)
            ->where('date', $date)
            ->exists();

        if ($isDoctorOnLeave) {
            return response()->json(['times' => []]); // No time slots if doctor is on leave
        }

        // Fetch all time slots for the doctor on the selected date
        $availableTimes = TimeSlot::all();

        // Fetch booked time slots
        $bookedTimes = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $date)
            ->pluck('appointment_time')
            ->toArray();

        // Flatten the booked times array if multiple times are stored in a single appointment
        $bookedTimes = Arr::flatten(array_map(function($time) {
        return explode(',', $time);
        }, $bookedTimes));

        // Prepare the response data
        $times = $availableTimes->map(function($timeSlot) use ($bookedTimes) {
            return [
                'time_slot' => $timeSlot->time_slot,
                'booked' => in_array($timeSlot->time_slot, $bookedTimes)
            ];
        });

        return response()->json(['times' => $times]);
    }

    public function searchProblem(Request $request)
    {
        $term = $request->input('term');
        $problems = EncounterMedicalProblems::where('problem', 'LIKE', '%' . $term . '%')->get();

        $results = [];

        foreach ($problems as $prob) {
           $results[] = [
            'label' => $prob->problem,  // The name displayed in the autocomplete dropdown
            'value' => $prob->problem    // The value inserted into the input when selected
          ];
        }

         return response()->json($results);

        
    }

    public function PrescriptionDetails($id)
    {
        $encounter = PatientEncounter::find($id);
        
        $patient = User::find($encounter->user_id);
        $medicines = EncounterPrescription::where('encounter_id',$encounter->id)->get();
        $doctor = User::find($encounter->doctor_id);

        $age = Carbon::parse($patient->date_of_birth)->age;

        $clinic = Clinics::find($encounter->clinic_id);
        session(['last_section' => 'medicine']);
        
        return view('backend.appointments.prescriptionPrint', compact('patient','medicines','encounter','doctor','age','clinic'));
    }

    public function Testprint($id)
    {
        $test = EncounterMedicalReport::find($id);
        $encounter = PatientEncounter::find($test->encounter_id);
        
        $patient = User::find($encounter->user_id);
        $doctor = User::find($encounter->doctor_id);

        $age = Carbon::parse($patient->date_of_birth)->age;

        $clinic = Clinics::find($encounter->clinic_id);

        session(['last_section' => 'test']);
        
        return view('backend.appointments.testPrint', compact('patient','test','encounter','doctor','age','clinic'));
    }

}

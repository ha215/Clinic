@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Left Side: Patient List & Encounter Details -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('t.Patient Details') }}</h5>
                </div>
                <div class="card-body">
                    <h6>{{ __('t.Name') }}: {{ $patient->first_name }}</h6>
                    <p>{{ __('t.Email') }}: {{ $patient->email }}</p>
                    <p>{{ __('t.MobileNumber') }}: {{ $patient->mobile  }}</p>
                    <p>{{ __('t.Status') }}: {{ $appointment->status ?? ''  }}</p>
                </div>
            </div>

            <!-- Option Tabs for Medicine, Test, Disease -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5>{{ __('t.Encounter Options') }}</h5>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary btn-block" id="medicineBtn">{{ __('t.Prescription') }}</button>
                    <button class="btn btn-primary btn-block" id="testBtn">{{ __('t.TestDetails') }}</button>
                    <button class="btn btn-primary btn-block" id="diseaseBtn">{{ __('t.Problems') }}</button>
                    </br>
                    
                     <button class="btn btn-success btn-block" id="HistoryBtn" style="margin-top: 10px;">{{ __('t.Patienthistory') }}</button>

                     <button class="btn btn-success btn-block" id="PMEBtn" style="margin-top: 10px;">{{ __('t.PMEUser') }}</button>
                   
                   <button class="btn btn-warning btn-block" id="addPMBBtn" data-patient-id="{{ $patient->id }}" style="display:none;">Add to PMB</button>
                   
                   <button class="btn btn-danger btn-block" id="checkoutBtn"  data-appointment-id="{{ $appointment->id }}" style="margin-top: 10px;">{{ __('t.Close&Checkout') }}</button>
                </div>
            </div>
        </div>

        <!-- Right Side: Dynamic Content for Medicine, Test, Disease -->
        <div class="col-md-8">
            <div id="medicineSection" class="d-none">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('t.MedicineDetails') }}</h5>
                        <button class="btn btn-success float-right" id="addMedicineBtn">Add Medicine</button>
                        <a href="{{ route('backend.print.Prescription', $encounter->id) }}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i>{{ __('t.print') }}</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Frequency</th>
                                    <th>Duration</th>
                                    <th>Instruction</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($medicines) > 0)
                                @forelse ($medicines as $medicine)
                                    <tr>
                                        <td>{{ $medicine->name }}</td>
                                        <td>{{ $medicine->frequency }}</td>
                                        <td>{{ $medicine->duration }}</td>
                                        <td>{{ $medicine->instruction }}</td>
                                        <td>
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No prescriptions found.</td>
                                    </tr>
                                @endforelse
                                @endif
                            </tbody>
                        </table>
                       
                    </div>
                </div>
            </div>

            <div id="testSection" class="d-none">
                <div class="card">
                    <div class="card-header">
                        <h5>Test Details</h5>
                        <button class="btn btn-success float-right" id="addTestBtn">Add Test</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Test Name</th>
                        <th>Date</th>
                        <th>Print</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($tests) > 0)
                    @forelse ($tests as $test)
                        <tr>
                            <td>{{ $test->name }}</td>
                            <td>{{ $test->date }}</td>
                            <td>
                                <a href="{{ route('backend.tests.print', $test->id) }}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i>{{ __('t.print') }}</a>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No tests added yet.</td>
                        </tr>
                    @endforelse
                    @endif
                </tbody>
            </table>
                        
                    </div>
                </div>
            </div>

            <div id="diseaseSection" class="d-none">
                <div class="card">
                    <div class="card-header">
                        <h5>Disease Details</h5>
                        <button class="btn btn-success float-right" id="addDiseaseBtn">Add Disease</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Problem</th>
                                    <th>Observation</th>
                                    <th>Note</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($diseases) > 0)
                                @forelse ($diseases as $disease)
                                    <tr>
                                        <td>{{ $disease->problem }}</td>
                                        <td>{{ $disease->observation }}</td>
                                        <td>{{ $disease->note }}</td>
                                        <td>
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No prescriptions found.</td>
                                    </tr>
                                @endforelse
                                @endif
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>

            <div id="PMESection" class="d-none">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('t.PMEUser') }}</h5>
                        <p><strong>{{ __('t.Name') }}:</strong> {{ $patient->first_name }}</p>
                        <p><strong>{{ __('t.CivilID') }}:</strong> {{ $patient->civil_id }}</p>
                        <p><strong>{{ __('t.MobileNumber') }}:</strong> {{ $patient->mobile }}</p>
                        <p><strong>{{ __('t.Department') }}:</strong> {{ $patient->department->name ?? ''}}</p>
                        <p><strong>{{ __('t.gender') }}:</strong> {{ $patient->gender }}</p>
                        <p><strong>{{ __('t.EmployeeId') }}:</strong> {{ $patient->employee_id }}</p>
                        <p><strong>{{ __('t.LastTestDate') }}:</strong> {{ $patient->previousTestDate()}}</p>
                        <p><strong>{{ __('t.UpcomingTestDate') }}:</strong> {{ $patient->upcomingTestDate() ? $patient->upcomingTestDate()->format('d-m-Y') : ' ' }}</p>
                        <p><strong>{{ __('t.PMEOption') }}:</strong> 
                            @if($patient->pme_year && $patient->pme_month)
                             {{ $patient->pme_year }} {{ __('Year') }}, {{ $patient->pme_month }} {{ __('Month') }}
                            @elseif($patient->pme_year)
                              {{ $patient->pme_year }} {{ __('Year') }}
                            @elseif($patient->pme_month)
                              {{ $patient->pme_month }} {{ __('Month') }}
                            @else
                              {{ __('Not Available') }}
                            @endif
                        </p>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('t.No') }}</th>
                                    <th>{{ __('t.TestName') }}</th>
                                    <th>{{ __('t.Date') }}</th>
                                    <th>{{ __('t.Result File') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($patient->encounterMedicalReports as $report)
                                <tr>
                                   <td>{{ $i }}</td>
                                   <td>{{ $report->name }}</td>
                                   <td>{{ $report->date }}</td>
                                   <td>
                                       @if ($report->doc_files)
                                       <a href="{{ asset($report->doc_files) }}" target="_blank">View</a>
                                      @endif
                                  </td>
                               </tr>
                               <?php $i++; ?>
                              @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
             

    <div id="HistorySection">
    <h6>{{ __('t.Patienthistory') }}</h6>
    <div class="accordion" id="appointmentAccordion">
        @forelse ($appointmentList as $index => $list)
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading_{{ $index }}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $index }}" aria-expanded="false" aria-controls="collapse_{{ $index }}">
                    {{ __('t.Appointmenton') }} {{ date('d-m-Y',strtotime($list->appointment->appointment_date))  }} {{ __('t.at') }} {{ $list->appointment->appointment_time }} - {{ $list->appointment->doctor->first_name }}
                </button>
            </h2>
            <div id="collapse_{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading_{{ $index }}" data-bs-parent="#appointmentAccordion">
                <div class="accordion-body">

                    <!-- Disease Section -->
                    <div id="diseaseSection_{{ $list->id }}" class="disease-section">
                        <h6>{{ __('t.DiseaseDetails') }}</h6>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('t.Problem') }}</th>
                                    <th>{{ __('t.Observation') }}</th>
                                    <th>{{ __('t.Note') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($list->diseases as $disease)
                                    <tr>
                                        <td>{{ $disease->problem }}</td>
                                        <td>{{ $disease->observation }}</td>
                                        <td>{{ $disease->note }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">{{ __('t.No_diseases_found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Test Section -->
                    <div id="testSection_{{ $list->id }}" class="test-section">
                        <h6>{{ __('t.TestDetails') }}</h6>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('t.TestName') }}</th>
                                    <th>{{ __('t.Date') }}</th>
                                    <th>{{ __('t.view') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($list->medicalReport as $test)
                                    <tr>
                                        <td>{{ $test->name }}</td>
                                        <td>{{ $test->date }}</td>
                                        <td> @if ($test->doc_files)
                                            <a href="{{ asset($test->doc_files) }}" target="_blank">View</a> @endif
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">{{ __('t.No_tests_found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Medicine Section -->
                    <div id="medicineSection_{{ $list->id }}" class="medicine-section">
                        <h6>{{ __('t.MedicineDetails') }}</h6>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('t.MedName') }}</th>
                                    <th>{{ __('t.Frequency') }}</th>
                                    <th>{{ __('t.Duration') }}</th>
                                    <th>{{ __('t.Instruction') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($list->prescriptions as $medicine)
                                    <tr>
                                        <td>{{ $medicine->name }}</td>
                                        <td>{{ $medicine->frequency }}</td>
                                        <td>{{ $medicine->duration }}</td>
                                        <td>{{ $medicine->instruction }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">{{ __('t.No_medicines_found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        @empty
        <p>{{ __('t.No_appointments_found_for_this_patient') }}</p>
        @endforelse
    </div>
    </div>


           
        </div>
    </div>
</div>

<!-- Add Medicine Modal -->
<div class="modal fade" id="addMedicineModal" tabindex="-1" role="dialog" aria-labelledby="addMedicineLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('backend_patients_saveMedicine') }}" method="POST">
                @csrf
                <input type="hidden" class="form-control" id="patient_encounter_id" name="patient_encounter_id" value="{{$encounter->id}}">
                 <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{$patient->id}}">
                 <input type="hidden" class="form-control" id="appoint_id" name="appoint_id" value="{{$encounter->appointment_id}}">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMedicineLabel">Add Medicine</h5>
                    <button type="button" class="close medCancel" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="medicineName">Medicine Name</label>
                        <input type="text" class="form-control" id="medicineName" name="medicine_name" required>
                    </div>
                    <div class="form-group">
                        <label for="frequency">Frequency</label>
                        <input type="text" class="form-control" id="frequency" name="frequency" required>
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration</label>
                        <input type="text" class="form-control" id="duration" name="duration" required>
                    </div>
                     <div class="form-group">
                        <label for="duration">Instruction</label>
                        <input type="text" class="form-control" id="instruction" name="instruction" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary medCancel" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Test Modal -->
<div class="modal fade" id="addTestModal" tabindex="-1" role="dialog" aria-labelledby="addTestModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('backend_patients_saveTest') }}" method="POST">
                <input type="hidden" class="form-control" id="patient_encounter_id" name="patient_encounter_id" value="{{$encounter->id}}">
                 <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{$patient->id}}">
                 <input type="hidden" class="form-control" id="appoint_id" name="appoint_id" value="{{$encounter->appointment_id}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addTestLabel">Add Test</h5>
                    <button type="button" class="close testCancel" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="testName">Test Name</label>
                        <input type="text" class="form-control" id="testName" name="test_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary testCancel"  data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Add Disease Modal -->
<div class="modal fade" id="addDiseaseModal" tabindex="-1" role="dialog" aria-labelledby="addDiseaseModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('backend_patients_saveDisease') }}" method="POST">
                <input type="hidden" class="form-control" id="patient_encounter_id" name="patient_encounter_id" value="{{$encounter->id}}">
                <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{$patient->id}}">
                <input type="hidden" class="form-control" id="appoint_id" name="appoint_id" value="{{$encounter->appointment_id}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addTestLabel">Add Disease</h5>
                    <button type="button" class="close DiseaseCancel" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="problem">Problem</label>
                        <input type="text" class="form-control" id="problem" name="problem" required>
                        <div id="problem-suggestions" class="list-group"></div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="observation">Observation</label>
                        <input type="text" class="form-control" id="observation" name="observation" required>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="note">Note</label>
                        <input type="text" class="form-control" id="note" name="note" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary DiseaseCancel" id="testcancel" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('after-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script>

    $(document).ready(function() {
   

    let lastSection = 'disease'; // Default section to open on page load

    // Show the disease section by default on page load
    toggleSection(lastSection);

    document.getElementById('medicineBtn').addEventListener('click', function() {
        lastSection = 'medicine';
        toggleSection(lastSection);
    });
    document.getElementById('testBtn').addEventListener('click', function() {
        lastSection = 'test';
        toggleSection(lastSection);
    });
    document.getElementById('diseaseBtn').addEventListener('click', function() {
        lastSection = 'disease';
        toggleSection(lastSection);
    });
    document.getElementById('PMEBtn').addEventListener('click', function() {
        lastSection = 'PME';
        toggleSection(lastSection);
    });
    document.getElementById('HistoryBtn').addEventListener('click', function() {
        lastSection = 'History';
        toggleSection(lastSection);
    });

    function toggleSection(section) {
        document.getElementById('medicineSection').classList.add('d-none');
        document.getElementById('testSection').classList.add('d-none');
        document.getElementById('diseaseSection').classList.add('d-none');
        document.getElementById('HistorySection').classList.add('d-none');
        document.getElementById('PMESection').classList.add('d-none');
        document.getElementById(section + 'Section').classList.remove('d-none');
    }

    // Show add medicine modal
    document.getElementById('addMedicineBtn').addEventListener('click', function() {
        $('#addMedicineModal').modal('show');
    });
   
    $('#addTestBtn').click(function() {
          $('#addTestModal').modal('show');
    });

    $('#addDiseaseBtn').click(function() {
          $('#addDiseaseModal').modal('show');
    });

    $('.medCancel').click(function() {
          $('#addMedicineModal').modal('hide');
    });

    $('.testCancel').click(function() {
          $('#addTestModal').modal('hide');
    });

    $('.DiseaseCancel').click(function() {
          $('#addDiseaseModal').modal('hide');
    });
    
    $('#checkoutBtn').on('click', function() {
        if(confirm('Are you sure you want to check out this appointment?')) {
            var appointmentId = $(this).data('appointment-id'); // Get the current appointment ID
            var status = "checkout"; 
            $.ajax({
                url: "{{ route('backend_update_status') }}", // Ensure this route is defined in your routes file
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    appointment_id: appointmentId,
                    status: status
                },
                success: function(response) {
                    if(response.success) {
                        alert(response.message); // Show success message
                        window.location.href = "{{ route('backend_patients_list') }}";
                    } else {
                        alert(response.message); // Show error message
                    }
                }
            });
        }
    });
    $('#addPMBBtn').on('click', function() {
        if(confirm('Are you sure you want to Add this patient to PMB?')) {
            var patientId = this.getAttribute('data-patient-id');; // Get the current appointment ID
            $.ajax({
                url: "{{ route('backend_PMB_status') }}", // Ensure this route is defined in your routes file
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    patientId: patientId
                },
                success: function(response) {
                    if(response.success) {
                        alert(response.message); // Show success message
                         location.reload();
                    } else {
                        alert(response.message); // Show error message
                    }
                }
            });
        }
    });

    
    $('#problem').on('keyup', function () {
            let query = $(this).val(); 
             // Start searching after 2 characters
                $.ajax({
                    url: "{{ route('backend_patients_searchProblem') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        term: query
                    },
                    success: function (data) {
                        $('#problem-suggestions').empty();
                        if (data.length > 0) {
                            data.forEach(function (item) {
                                $('#problem-suggestions').append(`
                                    <a href="#" class="list-group-item list-group-item-action problem-suggestion">${item.label}</a>
                                `);
                            });
                            $('.problem-suggestion').on('click', function () {
                                $('#problem').val($(this).text());
                                $('#problem-suggestions').empty();
                            });
                        }
                    }
                });
            
        });

        // Close the suggestion box if clicked outside
        $(document).on('click', function (e) {
            if (!$(e.target).closest('#problem, #problem-suggestions').length) {
                $('#problem-suggestions').empty();
            }
        });





    @if(session('last_section'))
        lastSection = '{{ session('last_section') }}';
        toggleSection(lastSection);
    @endif


 
});
</script>
@endpush

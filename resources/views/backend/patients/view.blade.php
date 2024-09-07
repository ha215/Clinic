@extends('backend.layouts.app')

@section('content')
<div class="card">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            &larr; {{ __('Back') }}
        </a>
    </div>

    <!-- Patient Details Section -->
    <div class="card mb-4 border-dark shadow">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">{{ __('Patient Details') }}</h5>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">{{ __('t.CivilID') }}</dt>
                <dd class="col-sm-9">{{ $patient->civil_id }}</dd>

                <dt class="col-sm-3">{{ __('t.Name') }}</dt>
                <dd class="col-sm-9">{{ $patient->first_name }}</dd>

                <dt class="col-sm-3">{{ __('t.Nationality') }}</dt>
                <dd class="col-sm-9">{{ $patient->nationality }}</dd>

                <dt class="col-sm-3">{{ __('t.Department') }}</dt>
                <dd class="col-sm-9">{{ $patient->department->name ?? '' }}</dd>

                <dt class="col-sm-3">{{ __('t.MobileNumber') }}</dt>
                <dd class="col-sm-9">{{ $patient->mobile }}</dd>

                <dt class="col-sm-3">{{ __('t.DateofBirth') }}</dt>
                <dd class="col-sm-9">{{ $patient->date_of_birth }}</dd>

                <dt class="col-sm-3">{{ __('t.gender') }}</dt>
                <dd class="col-sm-9">{{ $patient->gender }}</dd>

                <dt class="col-sm-3">{{ __('t.Email') }}</dt>
                <dd class="col-sm-9">{{ $patient->email }}</dd>
            </dl>
        </div>
    </div>

    <!-- Appointments History Section -->
    <div class="card mb-4 border-dark shadow">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">{{ __('Appointments History') }}</h5>
        </div>
        <div class="card-body">
            @foreach ($appointmentList as $appointment)
            <div class="accordion mb-3" id="accordion{{ $appointment->id }}">
                <div class="card border-dark">
                    <div class="card-header bg-light" id="heading{{ $appointment->id }}">
                        <h5 class="mb-0">
                            <button class="btn btn-link text-dark" type="button" data-toggle="collapse" data-target="#collapse{{ $appointment->id }}" aria-expanded="true" aria-controls="collapse{{ $appointment->id }}">
                                {{ date('d-m-Y', strtotime($appointment->appointment->appointment_date)) }} - {{ $appointment->appointment_time }} - {{ $appointment->appointment->doctor->first_name }}
                            </button>
                        </h5>
                    </div>

                    <div id="collapse{{ $appointment->id }}" class="collapse" aria-labelledby="heading{{ $appointment->id }}" data-parent="#accordion{{ $appointment->id }}">
                        <div class="card-body">
                            <!-- Problems Section -->
                            <div class="mb-4">
                                <h6>{{ __('DiseaseDetails') }}</h6>
                                @if($appointment->diseases->isEmpty())
                                    <p>{{ __('No problems recorded.') }}</p>
                                @else
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ __('t.Problem') }}</th>
                                                <th>{{ __('t.Observation') }}</th>
                                                <th>{{ __('t.Note') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($appointment->diseases as $disease)
                                                <tr>
                                                    <td>{{ $disease->problem }}</td>
                                                    <td>{{ $disease->observation }}</td>
                                                    <td>{{ $disease->note }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>

                            <!-- Medicines Section -->
                            <div class="mb-4">
                                <h6>{{ __('MedicineDetails') }}</h6>
                                @if($appointment->prescriptions->isEmpty())
                                    <p>{{ __('No medicines recorded.') }}</p>
                                @else
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ __('t.MedName') }}</th>
                                                <th>{{ __('t.Frequency') }}</th>
                                                <th>{{ __('t.Duration') }}</th>
                                                <th>{{ __('t.Instruction') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($appointment->prescriptions as $medicine)
                                                <tr>
                                                    <td>{{ $medicine->name }}</td>
                                                    <td>{{ $medicine->frequency }}</td>
                                                    <td>{{ $medicine->duration }}</td>
                                                    <td>{{ $medicine->instruction }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>

                            <!-- Tests Section -->
                            <div class="mb-4">
                                <h6>{{ __('TestDetails') }}</h6>
                                @if($appointment->medicalReport->isEmpty())
                                    <p>{{ __('No tests recorded.') }}</p>
                                @else
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ __('t.TestName') }}</th>
                                                <th>{{ __('t.Date') }}</th>
                                                <th>{{ __('t.view') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($appointment->medicalReport as $test)
                                                <tr>
                                                    <td>{{ $test->name }}</td>
                                                    <td>{{ $test->date }}</td>
                                                    <td> @if ($test->doc_files)
                                                     <a href="{{ asset($test->doc_files) }}" target="_blank">View</a> @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

@push('after-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
@endpush

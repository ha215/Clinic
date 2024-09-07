@extends('backend.layouts.app')

@section('title', 'Patient Details')

@section('content')
<div class="card">
    <div class="card-body">
        
        <h4>{{ $patient->first_name }} {{ $patient->last_name }}'s Details</h4>
        <hr>
        <p><strong>{{ __('t.CivilID') }}:</strong> {{ $patient->civil_id }}</p>
        <p><strong>{{ __('t.MobileNumber') }}:</strong> {{ $patient->mobile }}</p>
        <p><strong>{{ __('t.Department') }}:</strong> {{ $patient->department->name ?? ''}}</p>
        <p><strong>{{ __('t.gender') }}:</strong> {{ $patient->gender }}</p>
        <p><strong>{{ __('t.EmployeeId') }}:</strong> {{ $patient->employee_id }}</p>

        <hr>
        <h5>Previous Results</h5>
        <div class="table-responsive">
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

        <hr>
        <h5>{{ __('t.Upload_Latest_Results') }}</h5>
        <form action="{{ route('PMS_patients_upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
             <input type="hidden" class="form-control" name="id" value="{{$patient->id}}">
            <div class="form-group">
                <label for="doc_files">{{ __('t.Upload_Latest_Results') }}</label>
                <input type="file" class="form-control" name="doc_files" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">{{ __('t.Upload') }}</button>
        </form>
    </div>
</div>
@endsection

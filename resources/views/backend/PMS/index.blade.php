@extends('backend.layouts.app')

@section('title', 'Patient Management System')

@section('content')
<div class="card">
    <div class="card-body">
        <x-backend.section-header>
            <i class="fa fa-users"></i><b> {{ __('Patient Management System') }}</b>
        </x-backend.section-header>

        <hr>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('t.No') }}</th>
                        <th>{{ __('t.Name') }}</th>
                        <th>{{ __('t.CivilID') }}</th>
                        <th>{{ __('t.MobileNumber') }}</th>
                        <th>{{ __('t.Department') }}</th>
                        <th>{{ __('t.gender') }}</th>
                        <th>{{ __('t.LastTestDate') }}</th>
                        <th>{{ __('t.UpcomingTestDate') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($patients as $patient)
                    <tr>
                        <td>{{ $i}}</td>
                        <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                        <td>{{ $patient->civil_id }}</td>
                        <td>{{ $patient->mobile }}</td>
                        <td>{{ $patient->department->name ?? '' }}</td>
                        <td>{{ $patient->gender }}</td>
                        <td>{{ $patient->previousTestDate() }}</td>
                        <td>{{ $patient->upcomingTestDate() ? $patient->upcomingTestDate()->format('Y-m-d') : ' ' }}</td>
                       <td><a href="{{ route('PMS_patients_view', $patient->id) }}" >View</a></td>
                    </tr>
                    <?php $i++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

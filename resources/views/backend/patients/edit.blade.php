@extends('backend.layouts.app')

@section('title') {{ __('Edit Patient') }} @endsection

@section('content')
<div class="card">
    <div class="card-body">
        <x-backend.section-header>
            <i class="fa fa-user-edit"></i> {{ __('Edit Patient') }}
            <x-slot name="toolbar">
                <x-backend.buttons.return-back />
            </x-slot>
        </x-backend.section-header>

        <hr>

        <form action="{{ route('patients-update', $patient->id) }}" method="POST" class="form-horizontal">
            @csrf
            
          <input type="hidden" name="patient_id" class="form-control" value="{{ $patient->id }}" >
            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.CivilID') }}</label>
                <div class="col-sm-10">
                    <input type="text" name="civil_id" class="form-control" value="{{ $patient->civil_id }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.EmployeeId') }}</label>
                <div class="col-sm-10">
                    <input type="text" name="employee_id" value="{{ $patient->employee_id }}" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.Name') }}</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" value="{{ $patient->first_name }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.Department') }}</label>
                <div class="col-sm-10">
                    <select id="department" class="form-control" name="department_id" required>
                    <option value="">{{ __('Select Department') }}</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @if($patient->departments_id != null && $patient->departments_id == $department->id) selected @endif>{{ $department->name }}</option>
                    @endforeach
                </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.MobileNumber') }}</label>
                <div class="col-sm-10">
                    <input type="text" name="mobile_number" class="form-control" value="{{ $patient->mobile }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.Nationality') }}</label>
                <div class="col-sm-10">
                    <input type="text" name="Nationality" class="form-control"  value="{{ $patient->nationality }}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.Nationality') }}</label>
                <div class="col-sm-10">
                    <select id="Nationality" class="form-control" name="Nationality" required>
                    <option value="">{{ __('t.Select') }}</option>
                    @foreach ($nationalities as $nationality)
                        <option value="{{ $nationality->name }}" @if($patient->nationality != null) @if($patient->nationality == $nationality->name) selected @endif @endif>{{ $nationality->name }}</option>
                    @endforeach
                </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.DateofBirth') }}</label>
                <div class="col-sm-10">
                    <input type="date" name="date_of_birth" class="form-control" value="{{ $patient->date_of_birth }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.gender') }}</label>
                <div class="col-sm-10">
                    <select name="sex" class="form-control" required>
                        <option value="male" {{ $patient->gender == 'male' ? 'selected' : '' }}>@lang('Male')</option>
                        <option value="female" {{ $patient->gender == 'female' ? 'selected' : '' }}>@lang('Female')</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.Email') }}</label>
                <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" value="{{ $patient->email }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.PMEOption') }}</label>
                <div class="col-sm-5">
                    <input type="number" name="month" placeholder="{{ __('t.month') }}" class="form-control"  value="{{ $patient->email }}" required>
                </div>
                <div class="col-sm-5">
                    <input type="number" name="year" placeholder="{{ __('t.year') }}" class="form-control"  value="{{ $patient->email }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <button type="submit" class="btn btn-success">{{ __('t.Update') }}</button>
                </div>
                <div class="col-6">
                    <x-buttons.cancel />
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

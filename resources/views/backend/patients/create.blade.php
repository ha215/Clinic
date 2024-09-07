@extends('backend.layouts.app')

@section('title') {{ __('Create Patient') }} @endsection

@section('content')
<div class="card">
    <div class="card-body">
        <x-backend.section-header>
            <i class="fa fa-user-plus"></i> {{ __('Create Patient') }}
            <x-slot name="toolbar">
                <x-backend.buttons.return-back />
            </x-slot>
        </x-backend.section-header>

        <hr>

        <form action="{{ route('patients-store') }}" method="POST" class="form-horizontal">
            @csrf

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.CivilID') }}</label>
                <div class="col-sm-10">
                    <input type="text" name="civil_id" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.EmployeeId') }}</label>
                <div class="col-sm-10">
                    <input type="text" name="employee_id" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.Name') }}</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.Department') }}</label>
                <div class="col-sm-10">
                   <select id="department" class="form-control" name="department_id" required>
                    <option value="">{{ __('Select Department') }}</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.MobileNumber') }}</label>
                <div class="col-sm-10">
                    <input type="text" name="mobile_number" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.Nationality') }}</label>
                <div class="col-sm-10">
                    <select id="Nationality" class="form-control" name="Nationality" required>
                    <option value="">{{ __('t.Select') }}</option>
                    @foreach ($nationalities as $nationality)
                        <option value="{{ $nationality->name }}">{{ $nationality->name }}</option>
                    @endforeach
                </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.DateofBirth') }}</label>
                <div class="col-sm-10">
                    <input type="date" name="date_of_birth" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.gender') }}</label>
                <div class="col-sm-10">
                    <select name="sex" class="form-control" required>
                        <option value="male">@lang('Male')</option>
                        <option value="female">@lang('Female')</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.Email') }}</label>
                <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.PMEOption') }}</label>
                <div class="col-sm-5">
                    <input type="number" name="month" placeholder="{{ __('t.month') }}" class="form-control"  value="" required>
                </div>
                <div class="col-sm-5">
                    <input type="number" name="year" placeholder="{{ __('t.year') }}" class="form-control"  value="" required>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <button type="submit" class="btn btn-success">{{ __('t.Create') }}</button>
                </div>
                <div class="col-6">
                    <x-buttons.cancel />
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

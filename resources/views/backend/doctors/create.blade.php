@extends('backend.layouts.app')

@section('title') {{ __('Create Doctor') }} @endsection

@section('content')
<div class="card">
    <div class="card-body">
        <x-backend.section-header>
            <i class="fa fa-user-plus"></i> {{ __('t.CreateDoctor') }}
            <x-slot name="toolbar">
                <x-backend.buttons.return-back />
            </x-slot>
        </x-backend.section-header>

        <hr>

        <form action="{{ route('doctor-store') }}" method="POST" class="form-horizontal">
            @csrf

            <div class="form-group row">
                <label class="col-sm-2 form-control-label"> {{ __('t.CivilID') }}</label>
                <div class="col-sm-10">
                    <input type="text" name="civil_id" class="form-control" required>
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
                <label class="col-sm-2 form-control-label">{{ __('t.DateofBirth') }}</label>
                <div class="col-sm-10">
                    <input type="date" name="date_of_birth" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label">{{ __('t.gender') }}</label>
                <div class="col-sm-10">
                    <select name="sex" class="form-control" required>
                        <option value="Male">{{ __('t.Male') }}</option>
                        <option value="Female">{{ __('t.Female') }}</option>
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
                <label class="col-sm-2 form-control-label">{{ __('t.Services') }}</label>
                <div class="col-sm-10">
                    @foreach ($services as $service)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="services[]" value="{{ $service->id }}" id="service_{{ $service->id }}">
                            <label class="form-check-label" for="service_{{ $service->id }}">
                                {{ $service->name }}
                            </label>
                        </div>
                    @endforeach
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

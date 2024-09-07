@extends('backend.layouts.app')

@section('title', 'Manage Doctor')

@section('content')
<div class="card">
    <div class="card-body">
        <x-backend.section-header>
            <i class="fa fa-users"></i><b> {{ __('t.ManageDoctor') }}</b>
            <x-slot name="toolbar">
                <a href="{{ route('doctor-create') }}" class="btn btn-success">{{ __('t.CreateDoctor') }}</a>
            </x-slot>
        </x-backend.section-header>

        <hr>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>@lang('No')</th>
                        <th>@lang('Name')</th>
                        <th>@lang('Civil ID')</th>
                        <th>@lang('Mobile Number')</th>
                        <th>@lang('Department')</th>
                        <th>@lang('Gender')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($doctors as $doctor)
                    <tr>
                        <td>{{ $i}}</td>
                        <td>{{ $doctor->first_name }}</td>
                        <td>{{ $doctor->civil_id }}</td>
                        <td>{{ $doctor->mobile }}</td>
                        <td>{{ $doctor->department->name ?? '' }}</td>
                        <td>{{ $doctor->gender }}</td>
                        <td></td>
                    </tr>
                    <?php $i++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

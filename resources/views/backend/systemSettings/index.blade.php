@extends('backend.layouts.app')

@section('title') 
    {{ __('Settings') }} 
@endsection

@push('after-styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}">
@endpush

@section('content')
<div class="card">
    <div class="card-body">
        <h2>Settings</h2>

        <ul class="nav nav-tabs" id="settingsTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ request('tab') == 'nationalities' ? 'active' : '' }}" id="nationalities-tab" data-toggle="tab" href="#nationalities" role="tab" aria-controls="nationalities" aria-selected="{{ request('tab') == 'nationalities' ? 'true' : 'false' }}">Nationalities</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('tab') == 'problems' ? 'active' : '' }}" id="problems-tab" data-toggle="tab" href="#problems" role="tab" aria-controls="problems" aria-selected="{{ request('tab') == 'problems' ? 'true' : 'false' }}">Problems</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('tab') == 'services' ? 'active' : '' }}" id="services-tab" data-toggle="tab" href="#services" role="tab" aria-controls="services" aria-selected="{{ request('tab') == 'services' ? 'true' : 'false' }}">Services</a>
            </li>
        </ul>

        <div class="tab-content" id="settingsTabContent">
            <!-- Nationalities Tab -->
            <div class="tab-pane fade {{ request('tab') == 'nationalities' ? 'show active' : '' }}" id="nationalities" role="tabpanel" aria-labelledby="nationalities-tab">
                <h3 class="mt-3">Nationalities</h3>
                <form action="{{ route('settings.storeNationality') }}" method="POST" class="d-flex">
                    @csrf
                    <input type="text" name="Nationality" class="form-control mr-2" placeholder="Add Nationality">
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
                <ul class="mt-3">
                    @foreach($nationalities as $nationality)
                        <li>{{ $nationality->name }}</li>
                    @endforeach
                </ul>
            </div>

            <!-- Problems Tab -->
            <div class="tab-pane fade {{ request('tab') == 'problems' ? 'show active' : '' }}" id="problems" role="tabpanel" aria-labelledby="problems-tab">
                <h3 class="mt-3">Problems</h3>
                <form action="{{ route('settings.storeProblem') }}" method="POST" class="d-flex">
                    @csrf
                    <input type="text" name="Problem" class="form-control mr-2" placeholder="Add Problem">
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
                <ul class="mt-3">
                    @foreach($problems as $problem)
                        <li>{{ $problem->name }}</li>
                    @endforeach
                </ul>
            </div>

            <!-- Services Tab -->
            <div class="tab-pane fade {{ request('tab') == 'services' ? 'show active' : '' }}" id="services" role="tabpanel" aria-labelledby="services-tab">
                <h3 class="mt-3">Services</h3>
                <form action="{{ route('settings.storeService') }}" method="POST" class="d-flex">
                    @csrf
                    <input type="text" name="service" class="form-control mr-2" placeholder="Add Service">
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
                <ul class="mt-3">
                    @foreach($services as $service)
                        <li>{{ $service->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
@endpush

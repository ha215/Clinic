@extends('backend.layouts.app')

@section('title') {{ __('t.Patient Management') }} @endsection

@section('content')
<div class="card">
    <div class="card-body">
        <x-backend.section-header>
            <i class="fa fa-users"></i> {{ __('t.Patient Management') }}
            <x-slot name="toolbar">
                <div class="row align-items-center">
                   
                    <div class="col-md-8">
                        <!-- Search Form -->
                        <form id="searchForm" class="form-inline">
                            <div class="input-group">
                                <select name="filter_type" id="filterType" class="form-control">
                                    <option value="ALL">{{ __('t.ALL') }}</option>
                                    <option value="age">{{ __('t.Age') }}</option>
                                    <option value="nationality">{{ __('t.Nationality') }}</option>
                                    <option value="civil_id">{{ __('t.Civil ID') }}</option>
                                    <option value="name">{{ __('t.Name') }}</option>
                                </select>
                                <input type="text" name="search_query" id="searchQuery" class="form-control" placeholder="@lang('Enter your search query')">
                            </div>
                        </form>
                    </div>
                    
                    <div class="col-md-4 text-right">
                        <a href="{{ route('patients-create') }}" class="btn btn-success">{{ __('t.Create New Patient') }}</a>

                        <!-- Download Template Button -->
                        <a href="{{ route('patients.template') }}" class="btn btn-info" style="display:none;">{{ __('t.Download CSV Template') }}</a>

                        <form action="{{ route('patients.import') }}" method="POST" enctype="multipart/form-data" style="display: inline-block;">
        @csrf
        <input type="file" name="patient_import" class="form-control-file" style="display:none;" required>
        <button type="submit" class="btn btn-primary" style="display:none;">{{ __('t.Import Patients') }}</button>
    </form>
                    </div>
                </div>
            </x-slot>
        </x-backend.section-header>

        <hr>

        <div id="patientResults" class="table-responsive">
            @include('backend.patients.partials.patient_table', ['patients' => $patients])
        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>
<script>
    $(document).ready(function() {
    function fetchPatients(page = 1) {
        var filterType = $('#filterType').val();
        var searchQuery = $('#searchQuery').val();

        $.ajax({
            url: '{{ route("user_list") }}',
            method: 'GET',
            data: {
                filter_type: filterType,
                search_query: searchQuery,
                page: page
            },
            success: function(response) {
                $('#patientResults').html(response);
            }
        });
    }

    $('#searchQuery, #filterType').on('input change', function() {
        fetchPatients();
    });

    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        fetchPatients(page);
    });
});

</script>
@endpush

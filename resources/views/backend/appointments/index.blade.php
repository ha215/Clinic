@extends('backend.layouts.app')

@section('title') 
    {{ __('Appointment List') }} 
@endsection

@push('after-styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@section('content')
<div class="table-content mb-5">
    <x-backend.section-header>
        <x-slot name="toolbar">
            <div class="input-group flex-nowrap">
                <select id="search-filter" class="form-control">
                    <option value="">{{ __('t.Select Filter') }}</option>
                    <option value="department">{{ __('t.Department') }}</option>
                    <option value="doctor">{{ __('t.Doctor') }}</option>
                </select>
                <input type="text" id="search-name" class="form-control" placeholder="{{ __('Search by Name') }}">
                <input type="date" id="search-date" class="form-control" value="{{ now()->format('Y-m-d') }}">
                
                <button type="button" id="search-btn" class="btn btn-primary">{{ __('t.Search') }}</button>
            </div>
            
            <a href="{{ route('appoinment-create') }}" class="btn btn-success">{{ __('t.Create Appointment') }}</a>
        </x-slot>
    </x-backend.section-header>

    <div class="table-responsive">
        <table id="datatable" class="table table-striped">
            <thead>
                <tr>
                    <th>{{ __('t.No') }}</th>
                    <th>{{ __('t.CivilID') }}</th>
                    <th>{{ __('t.Name') }}</th>
                    <th>{{ __('t.MobileNumber') }}</th>
                    <th>{{ __('t.Appointment Date') }}</th>
                    <th>{{ __('t.Department') }}</th>
                    <th>{{ __('t.Doctor') }}</th>
                    <th>{{ __('t.Time') }}</th>
                    <th>{{ __('t.Status') }}</th> <!-- Add Status Column -->
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('after-scripts')
<script src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("appoinment-list") }}',
                data: function (d) {
                    d.filter_type = $('#search-filter').val();
                    d.name = $('#search-name').val();
                    d.date = $('#search-date').val();
                }
            },
            columns: [
                { data: null, name: 'id', searchable: false, sortable: false, render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { data: 'civil_id', name: 'civil_id' },
                { data: 'first_name', name: 'first_name' },
                { data: 'mobile_number', name: 'mobile_number' },
                { data: 'appointment_date', name: 'appointment_date' },
                { data: 'department', name: 'department' },
                { data: 'doctor', name: 'doctor' },
                { data: 'appointment_time', name: 'appointment_time' },
                { data: 'status', name: 'status', orderable: false, searchable: false, render: function (data, type, row) {
                    if (row.status === 'pending') {
                        return `
                            <select class="form-control update-status" data-appointment-id="${row.id}">
                                <option value="pending" ${row.status === 'pending' ? 'selected' : ''}>Pending</option>
                                <option value="check_in" ${row.status === 'check_in' ? 'selected' : ''}>Check In</option>
                                <option value="cancelled" ${row.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                                <option value="checkout" ${row.status === 'checkout' ? 'selected' : ''}>Check Out</option>
                            </select>
                        `;
                    } else {
                        return row.status;
                    }
                }}
            ]
        });

        $('#search-btn').on('click', function () {
            table.draw();
        });

        $(document).on('change', '.update-status', function () {
            var appointmentId = $(this).data('appointment-id');
            var status = $(this).val();

            $.ajax({
                url: '{{ route("backend_update_status") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    appointment_id: appointmentId,
                    status: status
                },
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                        table.draw(); // Redraw the table to reflect the changes
                    } else {
                        alert(response.message);
                    }
                }
            });
        });
    });
</script>
@endpush

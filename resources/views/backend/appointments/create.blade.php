@extends('backend.layouts.app')

@section('title') {{ __('Create Appointment') }} @endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('appoinment-store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="civil-id">{{ __('t.Search by Civil ID') }}</label>
                <input type="text" id="civil-id" class="form-control" name="civil_id" required>
            </div>

            <div id="patient-info" class="mb-3">
                <p><strong>{{ __('t.Name') }}:</strong> <span id="patient-first-name"></span></p>
                <p><strong>{{ __('t.MobileNumber') }}:</strong> <span id="patient-mobile"></span></p>
                <input type="hidden" id="patient_id" class="form-control" name="patient_id">
            </div>

            <div class="form-group">
                <label for="appointment-date">{{ __('t.SelectDate') }}</label>
                <input type="date" id="appointment-date" class="form-control" name="appointment_date" required>
            </div>

            <div class="form-group">
                <label for="department">{{ __('Department') }}</label>
                <select id="department" class="form-control" name="department_id" required>
                    <option value="">{{ __('Select Department') }}</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="doctor">{{ __('t.Doctors') }}</label>
                <select id="doctor" class="form-control" name="doctor_id" required>
                    <option value="">{{ __('Select Doctor') }}</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->first_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="service">{{ __('t.service') }}</label>
                <select id="service" class="form-control" name="service" required>
                    <option value="">{{ __('t.SelectService') }}</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="appointment-time">{{ __('t.AvailableTimes') }}</label>
                <div id="available-times">
                    <!-- Checkboxes for available times will be dynamically loaded here -->
                </div>
            </div>

            <div class="form-group" style="display: none;">
                <label for="room-number">{{ __('Room Number') }}</label>
                <input type="text" id="room-number" class="form-control" name="room_number" >
            </div>
            
            <div class="form-group" style="display: none;">
                <label for="amount">{{ __('Total Amount') }}</label>
                <input type="text" id="amount" class="form-control" name="amount" >
            </div>

            <button type="submit" class="btn btn-success">{{ __('t.Create') }}</button>
        </form>
    </div>
</div>
@endsection

@push('after-scripts')
<script>
    // AJAX for fetching patient details by Civil ID
    $('#civil-id').on('blur', function () {
        var civilId = $(this).val();
        if (civilId) {
            $.ajax({
                url: '{{ route("backend.patients.get_by_civil_id") }}',
                method: 'GET',
                data: { civil_id: civilId },
                success: function (data) {
                    $('#patient-first-name').text(data.first_name);
                    $('#patient-mobile').text(data.mobile);
                    $('#patient_id').val(data.id);
                }
            });
        }
    });

    // Fetch available time slots based on selected doctor and date
    // $('#appointment-date, #doctor').on('change', function () {
    //     var date = $('#appointment-date').val();
    //     var doctorId = $('#doctor').val();

    //     if (date && doctorId) {
    //         $.ajax({
    //             url: '{{ route("backend.appointments.get_available_times") }}',
    //             method: 'GET',
    //             data: { appointment_date: date, doctor_id: doctorId },
    //             success: function (data) {
    //                 $('#available-times').empty();
    //                 $.each(data.times, function (index, time) {
    //                     var checked = time.booked ? 'checked disabled' : '';
    //                     var color = time.booked ? 'background-color: #28a745;' : '';
    //                     var label = time.booked ? 'Booked' : time.time_slot;

    //                     $('#available-times').append(`
    //                         <div class="form-check form-check-inline">
    //                             <input class="form-check-input" type="checkbox" name="appointment_time[]" value="${time.time_slot}" ${checked} id="time${index}">
    //                             <label class="form-check-label" for="time${index}" style="${color}">${label}</label>
    //                         </div>
    //                     `);
    //                 });
    //             }
    //         });
    //     }
    // });


    $('#appointment-date, #doctor').on('change', function () {
    var date = $('#appointment-date').val();
    var doctorId = $('#doctor').val();

    if (date && doctorId) {
        $.ajax({
            url: '{{ route("backend.appointments.get_available_times") }}',
            method: 'GET',
            data: { appointment_date: date, doctor_id: doctorId },
            success: function (data) {
                $('#available-times').empty();
                $.each(data.times, function (index, time) {
                    var checked = time.booked ? 'checked disabled' : '';
                    var backgroundColor = time.booked ? '#28a745' : ''; // Green color for booked slots
                    var label = time.booked ? time.time_slot : time.time_slot;

                    $('#available-times').append(`
                        <div class="form-check form-check-inline">
                            <input class="form-check-input appointment-time-checkbox" type="checkbox" name="appointment_time" value="${time.time_slot}" ${checked} id="time${index}" style="background-color: ${backgroundColor};">
                            <label class="form-check-label" for="time${index}" style="color: ${backgroundColor}; padding: 5px; border-radius: 4px;">${label}</label>
                        </div>
                    `);
                });

                // Add change event listener to ensure only one checkbox can be selected
                $('.appointment-time-checkbox').on('change', function() {
                    $('.appointment-time-checkbox').not(this).prop('checked', false);
                });
            }
        });
    }
});


</script>
@endpush

@extends('backend.layouts.app')

@section('title') {{ __('Appointment List') }} @endsection

@section('content')
<div class="card">
    <div class="card-body">
        <x-backend.section-header>
            <i class="fa fa-users"></i> {{ __('Patients') }}
        </x-backend.section-header>

        <hr>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                          <th>{{ __('t.No') }}</th>
                          <th>{{ __('t.Appointment Date') }}</th>
                          <th>{{ __('t.Patient') }}</th>
                          <th>{{ __('t.Department') }}</th>
                          <th>{{ __('t.Appointment Time') }}</th>
                          <th>{{ __('t.Actions') }}</th>
                     </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                     @foreach ($appointments as $appointment)
                <tr>
                    <td>{{ $i}}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>{{ $appointment->patient->first_name }}</td>
                    <td>{{ $appointment->department->name ?? '' }}</td>
                    <td>
                        {{ $appointment->appointment_time ?? '' }}
                    </td>
                    <td>
                        <a href="{{ route('doctor.appointment.encounter', $appointment->id) }}" class="btn btn-primary btn-sm">Encounter</a>
                    </td>
                </tr>
                <?php $i++; ?>
            @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('after-scripts')

<script>
    $(document).ready(function() {
        $('.update-status').on('change', function() {
            var appointmentId = $(this).data('appointment-id');
            var status = $(this).val();
            
            $.ajax({
                url: "{{ route('backend_update_status') }}", // Define this route in your web.php
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    appointment_id: appointmentId,
                    status: status
                },
                success: function(response) {
                    if(response.success) {
                        alert(response.message); // Show success message
                        location.reload(); // Reload the page to reflect the changes
                    } else {
                        alert(response.message); // Show error message
                    }
                }
            });
        });
    });
</script>
@endpush

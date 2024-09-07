@extends('backend.layouts.app', ['isBanner' => false])

@section('title')
{{ 'Dashboard' }}
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between gap-3 flex-wrap mb-50">
    <div>
        <div class="d-flex align-items-center pb-3 pt-3">
            <span class="head-title fw-500">Main</span>
            <svg class="mx-2" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <g clip-path="url(#clip0_2007_2051)">
                    <path d="M2.625 2.25L6.375 6L2.625 9.75" stroke="#828A90" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M6.375 2.25L10.125 6L6.375 9.75" stroke="#828A90" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </g>
                <defs>
                    <clipPath id="clip0_2007_2051">
                        <rect width="12" height="12" fill="white" />
                    </clipPath>
                </defs>
            </svg>
            <span class="head-title fw-500 h6 mb-0">Dashboard</span>
        </div>
        <div class="user-info">
            <h1 class="fs-37">
                <span class="left-text text-capitalize fw-light">{{greeting()}}</span>
                <span class="right-text text-capitalize">{{$current_user}}</span>
            </h1>

        </div>
    </div>
    <div>

    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">{{ __('t.lbl_performance') }}</h3>
            <!-- <div class="d-flex  align-items-center">
                    <form action="{{ route('backend.home') }}" class="d-flex align-items-center gap-2">

                        <button type="submit" name="action" value="filter" class="btn btn-primary"
                            data-bs-toggle="tooltip"
                            data-bs-title="{{ __('messages.submit_date_filter') }}">{{ __('dashboard.lbl_submit') }}</button>

                    </form>
                </div> -->
        </div>
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <a href="{{route('backend_patients_list')}}" class="dashboard-link">
                <div class="card dashboard-cards">
                <div class="card-body text-center">
                    <img src="{{ asset('img/logo/list.png') }}" alt="Services" class="dashboard-icon hover-zoom">
                    <h2 class="mb-0" id="total_booking_count">{{ $data['total_appointments'] }}</h2>
                    <p class="card-title mt-3">{{ __('t.Listappointment') }} </p>
                    <button class="gradient-button">{{ __('t.ViewAppointments') }}</button>
                 </div>
                 </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-4">
                <a href="{{ route('backend.customers.index') }}" class="text-secondary">
                    <div class="card dashboard-cards appointments">
                        <div class="card-body">
                            <p class="mb-0">{{__('t.total_number_of_patients')}} </p>
                            <div class="d-flex align-items-center justify-content-between gap-3 mt-5">
                                <h2 class="mb-0">{{ $data['total_patient']}}</h2>
                                <img src="{{ asset('img/dashboard/users.png') }}" alt="image">
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-4">
                <a href="{{ route('backend.services.index') }}" class="text-secondary">
                    <div class="card dashboard-cards appointments">
                        <div class="card-body">
                            <p class="mb-0">{{__('t.total_number_of_services')}}</p>
                            <div class="d-flex align-items-center justify-content-between gap-3 mt-5">
                                <h2 class="mb-0">{{$data['total_service_count']}}</h2>
                                <img src="{{ asset('img/dashboard/services.png') }}" alt="image">
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('after-styles')
<style>
    #chart-01 {
        height: 28.5rem;
    }

    #chart-02 {
        height: 22.5rem;
    }

    .list-group {
        --bs-list-group-item-padding-y: 1.5rem;
        --bs-list-group-color: inherit !important;
    }

    .date-calender {
        display: flex;
        justify-content: space-between;
    }

    .date-calender .date {
        width: 12%;
        display: flex;
        align-items: center;
        flex-direction: column
    }

    .upcoming-appointments {
        min-height: 28rem;
        max-height: 28rem;
        overflow-y: scroll;


    }

    .iq-upcomming {
        display: flex !important;
        justify-content: center;
        align-items: center;
    }

     /* Dashboard Container */
    .dashboard-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .dashboard-card {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-align: center;
        padding: 20px;
    }

    .dashboard-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    /* Card Icon */
    .dashboard-icon {
        width: 60px;
        height: 60px;
        margin-bottom: 10px;
        transition: transform 0.3s ease;
    }

    .dashboard-icon:hover {
        transform: scale(1.1);
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #555;
    }

    /* Links */
    .dashboard-link {
        text-decoration: none;
        color: inherit;
    }

    /* Button Styles */
    .flat-button {
        background-color: #6c5ce7;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        cursor: pointer;
    }

    .flat-button:hover {
        background-color: #a29bfe;
    }

    .outline-button {
        background-color: transparent;
        color: #6c5ce7;
        border: 2px solid #6c5ce7;
        padding: 10px 20px;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 5px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .outline-button:hover {
        background-color: #6c5ce7;
        color: white;
    }

    .gradient-button {
        background: linear-gradient(135deg, #6c5ce7, #a29bfe);
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 30px;
        transition: transform 0.3s ease, background 0.3s ease;
        cursor: pointer;
    }

    .gradient-button:hover {
        transform: scale(1.05);
        background: linear-gradient(135deg, #a29bfe, #6c5ce7);
    }

    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }
    @keyframes zoom {
        from {transform: scale(0)}
        to {transform: scale(1)}
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.40.0/apexcharts.min.css" integrity="sha512-tJYqW5NWrT0JEkWYxrI4IK2jvT7PAiOwElIGTjALSyr8ZrilUQf+gjw2z6woWGSZqeXASyBXUr+WbtqiQgxUYg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@push('after-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.40.0/apexcharts.min.js" integrity="sha512-Kr1p/vGF2i84dZQTkoYZ2do8xHRaiqIa7ysnDugwoOcG0SbIx98erNekP/qms/hBDiBxj336//77d0dv53Jmew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     var calendarEl = document.getElementById('calendar');
    //     var calendar = new FullCalendar.Calendar(calendarEl, {
    //         initialView: 'dayGridMonth',
    //         themeSystem: 'bootstrap',
    //         events: function(info, successCallback, failureCallback) {
    //             $.ajax({
    //                 url: "{{ route('backend.get-appointments') }}",
    //                 dataType: 'json',
    //                 success: function(response) {
    //                     if (response.status && response.data && Array.isArray(response.data)) {
    //                         var events = response.data.map(function(appointment) {
    //                             return {
    //                                 id: appointment.id,
    //                                 name: appointment.user.first_name,
    //                                 title: appointment.service_name,
    //                                 start: appointment.start_date_time,
    //                             };
    //                         });
    //                         successCallback(events);
    //                     } else {
    //                         failureCallback("Invalid data format.");
    //                     }
    //                 },
    //                 error: function(xhr, status, error) {
    //                     failureCallback(error);
    //                 }
    //             });
    //         },
    //         eventColor: 'rgb(19, 193, 240)',
    //         textColor: '#fff',
    //         timeFormat: {
    //             agenda: 'H(:mm)' //h:mm{ - h:mm}'
    //         },
    //         eventDidMount: function(info) {
    //             $(info.el).tooltip({
    //                 title: info.event.extendedProps.name + ' - ' + info.event.title,
    //                 placement: 'top',
    //                 trigger: 'hover',
    //                 container: 'body'
    //             });
    //         },
    //         eventClick: function(info) {
    //             var id = info.event.id;
    //             var url = "{{ URL::to('app/appointments/clinicAppointmentDetail') }}/" + id;
    //             window.location.replace(url);
    //         },
    //         timeFormat: 'H(:mm)',
    //         eventTimeFormat: { // Set the format for event times
    //             hour: 'numeric',
    //             minute: '2-digit',
    //             meridiem: 'short' // Optionally, you can set meridiem to false to display 24-hour format
    //         },
    //     });
    //     calendar.render();
    // });


  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        themeSystem: 'bootstrap',
        events: function(info, successCallback, failureCallback) {
            $.ajax({
                url: "{{ route('backend.get-appointments') }}",
                dataType: 'json',
                success: function(response) {
                    if (response.status && response.data && Array.isArray(response.data)) {
                        var events = response.data.map(function(appointment) {
                            var color;
                            switch (appointment.status) {
                                case 'pending':
                                    color = 'orange';
                                    break;
                                case 'cancelled':
                                    color = 'red';
                                    break;
                                case 'check_in':
                                    color = 'blue';
                                    break;
                                case 'checkout':
                                    color = 'green';
                                    break;
                                default:
                                    color = 'gray'; // Fallback color if status doesn't match any case
                                    break;
                            }

                            return {
                                id: appointment.id,
                                name: appointment.user.first_name,
                                title: appointment.service_name + ' - ' + appointment.status,
                                start: appointment.start_date_time,
                                backgroundColor: color, // Set the background color
                                borderColor: color, // Set the border color
                                textColor: color // Set the text color (white)
                            };
                        });
                        successCallback(events);
                    } else {
                        failureCallback("Invalid data format.");
                    }
                },
                error: function(xhr, status, error) {
                    failureCallback(error);
                }
            });
        },
        eventColor: 'rgb(19, 193, 240)',
        textColor: '#fff',
        timeFormat: {
            agenda: 'H(:mm)' //h:mm{ - h:mm}'
        },
        eventDidMount: function(info) {
            $(info.el).tooltip({
                title: info.event.extendedProps.name + ' - ' + info.event.title,
                placement: 'top',
                trigger: 'hover',
                container: 'body'
            });
        },
        eventClick: function(info) {
            var id = info.event.id;
            var url = "{{ URL::to('app/appointments/clinicAppointmentDetail') }}/" + id;
            window.location.replace(url);
        },
        timeFormat: 'H(:mm)',
        eventTimeFormat: { // Set the format for event times
            hour: 'numeric',
            minute: '2-digit',
            meridiem: 'short' // Optionally, you can set meridiem to false to display 24-hour format
        },
    });
    calendar.render();
});





</script>


@endpush
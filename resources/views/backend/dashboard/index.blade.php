@extends('backend.layouts.app', ['isBanner' => false])

@section('title')
{{ 'Dashboard' }}
@endsection

@section('content')

<div class="user-info mb-50 text-left">
    <h1 class="fw-500">
        <span class="left-text text-capitalize fw-light">{{greeting()}} </span>
        <span class="right-text text-capitalize">{{$current_user}}</span>
    </h1>
</div>

<div class="dashboard-container">
    <!-- Appointments Card -->
    <div class="dashboard-card">
        <a href="{{route('user_list')}}" class="dashboard-link">
            <div class="card dashboard-cards">
                <div class="card-body text-center">
                    <img src="{{ asset('img/logo/add.png') }}" alt="Appointments" class="dashboard-icon hover-zoom">
                    <p class="card-title mt-3">{{ __('t.Patient Management') }}</p>
                    <button class="gradient-button">{{ __('t.ViewPatients') }}</button>
                </div>
            </div>
        </a>
    </div>
    
    <!-- Services Card -->
    <div class="dashboard-card">
        <a href="{{route('appoinment-list')}}" class="dashboard-link">
            <div class="card dashboard-cards">
                <div class="card-body text-center">
                    <img src="{{ asset('img/logo/list.png') }}" alt="Services" class="dashboard-icon hover-zoom">
                    <p class="card-title mt-3">{{ __('t.Listappointment') }}</p>
                    <button class="gradient-button">{{ __('t.ViewAppointments') }}</button>
                </div>
            </div>
        </a>
    </div>
    
    <!-- Clinics Card -->
    <div class="dashboard-card">
        <a href="{{route('appoinment-create')}}" class="dashboard-link">
            <div class="card dashboard-cards">
                <div class="card-body text-center">
                    <img src="{{ asset('img/logo/shedule.png') }}" alt="Clinics" class="dashboard-icon hover-zoom">
                    <p class="card-title mt-3">{{ __('t.Scheduleanappointment') }}</p>
                    <button class="gradient-button">{{ __('t.ScheduleNow') }}</button>
                </div>
            </div>
        </a>
    </div>

    <!-- Users Card -->
    <div class="dashboard-card">
        <a href="{{route('PMS_patients_list')}}" class="dashboard-link">
            <div class="card dashboard-cards">
                <div class="card-body text-center">
                    <img src="{{ asset('img/logo/previous.png') }}" alt="Users" class="dashboard-icon hover-zoom">
                    <p class="card-title mt-3">{{ __('t.PME') }}</p>
                    <button class="gradient-button">{{ __('t.ManagePatients') }}</button>
                </div>
            </div>
        </a>
    </div>
    <div class="dashboard-card">
        <a href="{{route('doctor-list')}}" class="dashboard-link">
            <div class="card dashboard-cards">
                <div class="card-body text-center">
                    <img src="{{ asset('img/logo/doc.png') }}" alt="Users" class="dashboard-icon hover-zoom">
                    <p class="card-title mt-3">{{ __('t.Doctors') }}</p>
                    <button class="gradient-button">{{ __('t.ManageDoctor') }}</button>
                </div>
            </div>
        </a>
    </div>

    <div class="dashboard-card">
        <a href="{{route('settings-index')}}" class="dashboard-link">
            <div class="card dashboard-cards">
                <div class="card-body text-center">
                    <img src="{{ asset('img/logo/settings.png') }}" alt="Users" class="dashboard-icon hover-zoom">
                    <p class="card-title mt-3">{{ __('t.Settings') }}</p>
                    <button class="gradient-button">{{ __('t.ManageSettings') }}</button>
                </div>
            </div>
        </a>
    </div>

   <!--  <div class="dashboard-card">
        <a href="{{route('encounter-medical-report.missing')}}" class="dashboard-link">
            <div class="card dashboard-cards">
                <div class="card-body text-center">
                    <img src="{{ asset('img/logo/doc.png') }}" alt="Users" class="dashboard-icon hover-zoom">
                    <p class="card-title mt-3">{{ __('t.filemangement') }}</p>
                    <button class="gradient-button">{{ __('t.Upload File') }}</button>
                </div>
            </div>
        </a>
    </div> -->

</div>

<!-- Modal HTML -->
<div id="imageModal" class="image-modal">
    <span class="close" onclick="closeImageModal()">&times;</span>
    <img class="modal-content" id="modalImage">
    <div id="caption"></div>
</div>

@endsection

@push('after-styles')
<style>
    /* General Styles */
    body {
        background-color: #f0f4f7;
        font-family: 'Poppins', sans-serif;
        color: #333;
    }

    .user-info {
        margin-bottom: 50px;
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

    /* Modal Styles */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 60px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.8);
    }

    .image-modal .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #fff;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .image-modal .close:hover,
    .image-modal .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    .image-modal .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        border-radius: 15px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
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

    .image-modal .modal-content, #caption {
        animation: zoom 0.6s;
    }

    @keyframes zoom {
        from {transform: scale(0)}
        to {transform: scale(1)}
    }
    

</style>

@endpush

@push('after-scripts')
<script>
    function showImageModal(image, caption) {
        document.getElementById('imageModal').style.display = "block";
        document.getElementById('modalImage').src = "{{ asset('img/logo/') }}" + '/' + image;
        document.getElementById('caption').innerHTML = caption;
    }

    function closeImageModal() {
        document.getElementById('imageModal').style.display = "none";
    }
</script>
@endpush

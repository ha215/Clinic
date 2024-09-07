@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="card-body">
        <x-backend.section-header>
            <i class="fa fa-users"></i><b> {{ __('t.uploadReports') }}</b>
        </x-backend.section-header>

        <hr>

    @if(session('success'))
    <div class="alert alert-success" id="flash-message">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(function() {
            document.getElementById('flash-message').style.display = 'none';
        }, 3000); 
    </script>
    @endif


        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('t.No') }}</th>
                        <th>{{ __('t.Name') }}</th>
                        <th>{{ __('t.CivilID') }}</th>
                        <th>{{ __('t.TestName') }}</th>
                        <th>{{ __('t.MobileNumber') }}</th>
                        <th>{{ __('t.Department') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                     @foreach($reports as $report)
                    <tr>
                       <td>{{ $loop->iteration }}</td>
                       <td>{{ $report->user->first_name ?? '' }}</td>
                       <td>{{ $report->user->civil_id ?? ''}}</td>
                       <td>{{ $report->name }}</td>
                       <td>{{ $report->user->mobile ?? '' }}</td>
                       <td>{{ $report->user->department->name ?? '' }}</td>
                       <td>
                        <button class="btn btn-primary showModel" data-toggle="modal" data-target="#uploadModal" data-id="{{ $report->id }}" id="showModel" data-name="{{ $report->name }}">
                            Upload
                        </button>
                       </td>
                    </tr>
                    <?php $i++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload Document</h5>
                <button type="button" class="close cancelModel" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('encounter-medical-report.uploadFile') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <input type="hidden" class="form-control" id="report_id" name="report_id" >
                <div class="modal-body">
                    <div class="form-group">        
                        <label for="doc_file">Upload Document for <span id="reportName"></span></label>
                        <input type="file" class="form-control-file" id="doc_file" name="doc_file" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cancelModel" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script>
 $(document).ready(function() {
    $('.showModel').click(function() {
          var reportId = $(this).data('id'); 
          $('#report_id').val(reportId);
          $('#uploadModal').modal('show'); 
    });
    $('.cancelModel').click(function() {
          $('#report_id').val('');
          $('#uploadModal').modal('hide');
    });
   

});
</script>
@endpush

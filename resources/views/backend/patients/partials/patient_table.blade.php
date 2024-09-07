<table class="table table-striped">
    <thead>
        <tr>
            <th>{{ __('t.No') }}</th>
            <th>{{ __('t.CivilID') }}</th>
            <th>{{ __('t.Name') }}</th>
            <th>{{ __('t.Nationality') }}</th>
            <th>{{ __('t.Department') }}</th>
            <th>{{ __('t.MobileNumber') }}</th>
            <th>{{ __('t.DateofBirth') }}</th>
            <th>{{ __('t.gender') }}</th>
            <th>{{ __('t.Email') }}</th>
            <th>{{ __('t.Actions') }}</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        @foreach ($patients as $patient)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $patient->civil_id }}</td>
            <td>{{ $patient->first_name }}</td>
            <td>{{ $patient->nationality }}</td>
            <td>{{ $patient->department->name ?? '' }}</td>
            <td>{{ $patient->mobile }}</td>
            <td>{{ $patient->date_of_birth }}</td>
            <td>{{ $patient->gender }}</td>
            <td>{{ $patient->email }}</td>
            <td>
                <a href="{{ route('patients-edit', $patient->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                <form action="{{ route('patients-create', $patient->id) }}" method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('t.Delete') }}</button>
                </form>
                @if(Auth::user()->user_type != 'receptionist')
                <a href="{{ route('patients-view', $patient->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                @endif
            </td>
        </tr>
         <?php $i++; ?>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {!! $patients->links() !!}
</div>

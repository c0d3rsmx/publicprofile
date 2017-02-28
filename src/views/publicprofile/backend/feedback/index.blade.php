@extends(config('publicprofile.views_to_use').'::backend.layout.app')
{{-- view extends are customizable --}}



@section('content')

    <div class="container">
        <table class="table">
            <thead>
                <th>Guest Id</th>
                <th>Nickname</th>
                <th>Feedback</th>
                <th>Status</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @foreach($profile_feedbacks as $pf)
                    <tr>
                    <td>{{ $pf->guest_id }}</td>
                    <td>{{ $pf->guest_nickname }}</td>
                    <td>{{ $pf->feedback }}</td>
                    <td>@if($pf->status)<span class="label label-success">Enabled</span> @else <span class="label label-danger">Disabled</span> @endif</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('backend_profile_feedbacks_enable', ['feedback_id' => $pf->id]) }}" class="btn @if($pf->status) btn-warning @else btn-primary @endif"> @if($pf->status) Disable @else Enable @endif</a>
                            <a href="{{ route('backend_profile_feedbacks_destroy', ['feedback_id' => $pf->id]) }}" class="btn btn-danger">Delete</a>
                        </div>
                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>




@endsection